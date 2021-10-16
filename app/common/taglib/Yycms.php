<?php
namespace app\common\taglib;
use think\template\TagLib;
use think\facade\View;
class Yycms extends TagLib{
    /**
     * 定义标签列表
     */
    protected $tags   =  [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'channel'             => ['typeid,type,order,row', 'alias' => 'iterate','close' => 1],   //typeid:栏目id|默认0,order:排序方式desc|asc|默认desc,row条数
        'channelartlist'      => ['typeid,order,row,pagesize', 'alias' => 'iterate','close' => 1,'level'=>3],   //typeid:栏目id|默认0,order:排序方式desc|asc|默认desc,row条数
        'arclist'             => ['typeid,channelid,order,row,flag,titlelen', 'alias' => 'iterate','close' => 1],   //
        'list'                => ['order,row,flag,titlelen', 'alias' => 'iterate','close' => 1],   //列表页
        'field'               => ['name,row,flag,titlelen', 'alias' => 'iterate','close' => 1],   //field
        'sql'                 => ['sql', 'alias' => 'sql','close' => 1],   //sql查询
        'type'                => ['typeid', 'alias' => 'sql','close' => 1],   //type查询栏目
        'advert'              => ['group_id,order,row,titlelen', 'alias' => 'ad','close' => 1],  //广告管理
        'flink'              => ['row,type,name', 'alias' => 'flink', 'close' => 1],  //友情链接
        'prenext'            => ['attr' => 'get','close' => 0],  //上一篇、下一篇
    ];
    /**
     * 栏目channel 标签
     * @param type $tag
     * @param type $content
     * @return string
     */
    public function tagChannel($tag, $content){
        
        if(!isset($typeid)) {$typeid= empty($tag['typeid']) ? 0 : $tag['typeid'];};//栏目ID
        $type= empty($tag['type']) ? 'top' : $tag['type'];//类型
        $order= empty($tag['order']) ? "sortrank asc": $tag['order'];//排序
        $row= empty($tag['row']) ? 10: $tag['row'];//条数
        $currentstyle= empty($tag['cur']) ? 'on': $tag['currentstyle'];//条数
        $parseStr = '<?php ';
        $parseStr.='
        $where=[];
        $menuList=[];
        $where[]=["ishidden","=",0];
        if("'.$type.'"=="top") $where[] =["reid","=",0];
        if("'.$type.'"=="son"){
            if(empty("'.$typeid.'")) {
              $typeid =input("tid");
            }else{
              $typeid ="'.$typeid.'";
            }
            $where[]=[\'reid\',\'in\', explode(",",$typeid)];
        }
        if("'.$type.'"=="self") $where[] =["id","in", explode(",","'.$typeid.'")];
           
        $ArctypeModel=new \app\common\model\Arctype();
        $menuList= $ArctypeModel->where($where)->order("'.$order.'")->limit('.$row.')->select()->toArray();
       
        $tid= request()->param("tid");
        $currid=$ArctypeModel->childrenIds($menuList,$tid);
        $currid[]=$tid;
            foreach($menuList as $index=>$field){
                    $field["typeurl"]=url("template/list",["tid"=>$field["id"]]);
                    $field["currentstyle"]=in_array($field["id"],$currid)?"'.$currentstyle.'":"";//栏目显示高亮
                    $typeid=$field["id"];//嵌套标签typeid传值
            ';
        $parseStr.='?>';
        $parseStr.=$content;
        $parseStr.='<?php }  ?>';
        return $parseStr;
    }
    /**
     * 栏目三级嵌套
     * @param type $tag
     * @param type $content
     * @return string
     */
    public function tagChannelartlist($tag, $content){
       
        $typeid= empty($tag['typeid']) ? 0 : $tag['typeid'];//栏目ID
        $order= empty($tag['order']) ? "desc": $tag['order'];//排序
        $row= empty($tag['row']) ? 10: $tag['row'];//条数
        $parseStr = '<?php $currentstyle="";';
        $parseStr.='
            $where=["ishidden"=>0,"reid"=>'.$typeid.'];
            $ArctypeModel=new \app\common\model\Arctype();
            $menuList= $ArctypeModel->where($where)->order("sortrank","'.$order.'")->limit(0,'.$row.')->select()->toArray(); 
            $currid=[];
            if(input("tid")){
                 $currid=$ArctypeModel->artypeCurrId(input("tid"));
                 $currid[]=input("tid");
            }
            foreach($menuList as $key=>$field){
                $field["typeurl"]=url("template/list",["tid"=>$field["id"]]);
                $currentstyle=in_array($field["id"],$currid)?"cur":"";//栏目显示高亮
                $typeid=$field["id"];//嵌套标签typeid传值
            ';
        $parseStr.='?>';
        $parseStr.=$content;
        $parseStr.='
                <?php 
            }
            ?>
        ';

        return $parseStr;
    }
    public function tagArclist($tag, $content){
        if(input('tid')) {
            $typeid = empty($tag['typeid']) ? input('tid') : $tag['typeid'];//栏目ID
        } else { 
            $typeid = isset($tag['typeid'])&&empty($tag['typeid']) ?  $tag['typeid'] : 'all';//栏目ID
        }
        $order= empty($tag['order']) ? "sortrank asc": $tag['order'];//排序
        $row= empty($tag['row']) ? 10: $tag['row'];//条数    
        $limit='0,'.$row;
        $flag= !empty($tag['flag'])?$tag['flag']:'0';
        $pagesize= empty($tag['pagesize']) ? 10: $tag['pagesize'];//条数    
        $channelid= empty($tag['channelid']) ? 1: $tag['channelid'];//模型ID   
        $parseStr = '<?php ';
        $parseStr.='
            $where=[];
            $where[]=["arc.arcrank","=",0];
            if("'.$typeid.'"!="all"){
               $where[]=["arc.typeid","in","'.$typeid.'"];
            }
            if(in_array("'.$flag.'",["c","f","h","p","j"])){
                $where[]=["arc.flag","like","%'.$flag.'%"]; 
            }
            $ChanneltypeModel=new \app\common\model\Channeltype();
            $Channeltype=$ChanneltypeModel->find('.$channelid.');
            $serializefield =explode(",",$Channeltype->serializefield);
            $list=\think\facade\Db::name("archives")
                            ->alias("arc")
                            ->join($Channeltype->addtable." add"," arc.id=add.aid","left")
                            ->where($where)
                            ->order("arc.'.$order.',arc.id asc")->limit('.$limit.')
                            ->select()
                            ->toArray();
            foreach($list as $index=>$field){
//                foreach($field as $k=>$v){
//                    if(in_array($k,$serializefield)){
//                        //$field[$k] = \fun\Process::decode_item($v);//序列化字段
//                    }
//                }
                $field["info"]=$field["description"]; 
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"])?$field["redirecturl"] : url("template/view",["aid"=>$field["aid"]])->build();
            ';
        $parseStr.='?>';
        $parseStr.=$content;
        $parseStr.='
                <?php 
            }
            ?>
        ';
        return $parseStr;
    }
    public function tagList($tag, $content){
        
        $order= empty($tag['order']) ? " desc": $tag['order'];//排序
        $row= empty($tag['row']) ? 10: $tag['row'];//条数    
        
        //$pagesize= empty($tag['pagesize']) ? 1: $tag['pagesize'];//条数    
        
        $typeid=input("tid");
        $parseStr = '<?php ';
        $parseStr.='
            if(input("page")){
                $pagesize=(input("page")*'.$row.')-'.$row.';
            }else{
                $pagesize=0;
            }
            $where=["status"=>1];
            $where["typeid"] ='.$typeid.';
            $ArclistModel=new \app\common\model\Arclist();
            $arctList= $ArclistModel->where($where) 
                                     ->order("sortrank '.$order.'")
                                     ->limit($pagesize,'.$row.')
                                     ->select();
            foreach($arctList as $index=>$field){
                $field["litpic"]=explode(",",$field["litpic"]); //缩略图
                $field["arcurl"]="view/aid/".$field["id"];
            ';
        $parseStr.='?>';
        $parseStr.=$content;
        $parseStr.='
                <?php 
            }
            ?>
        ';
        return $parseStr;
    }
    /**
     * 广告管理
     * @param type $tag
     * @param type $content
     * @return string
     */
    public function tagAdvert($tag,$content){
        $group_id= empty($tag['group_id']) ? 1 : $tag['group_id'];//组ID
        $order= empty($tag['order']) ? "sortrank asc": $tag['order'];//排序
        $row= empty($tag['row']) ? 10: $tag['row'];//条数    
        $parseStr = '<?php ';
        $parseStr.='
            $where = [];
            $where[] = ["group_id","=",'.$group_id.'];
            $AdvertModel = new \app\common\model\Advert();
            $list=$AdvertModel->where($where)->select()->toArray();
                    foreach($list as $key => $field){';
        $parseStr.='?>';
        $parseStr.=$content;
        $parseStr.='
           <?php 
            }
            ?>
        ';
        return $parseStr;   
    }
    /**
     * 上一篇、下一篇
     * @param type $tag
     * @param type $content
     * @return string
     */
     public function tagPrenext ($tag,$content){
        $getparam = $tag["get"];
        if(!$getparam) return '';
        $parse = '<?php ';
        $parse .= '$aid = input("aid");
            if($aid){
                $Arclist = \app\common\model\Arclist::find($aid);
                $where = [];
                $where[] = ["typeid","=",$Arclist->typeid];
                if("'.$getparam.'"=="pre"){
                    $where[] = ["id","<",$aid];
                    $text ="上一篇";
                 }else{
                    $where[] = ["id",">",$aid];
                    $text ="下一篇";
                }
                $info = \app\common\model\Arclist::where($where)->limit(1)->find();
                if($info){
                    $url = "/view/aid/".$info->id;
                    echo "<a href =\'".$url."\'><span>".$text."</span><b>：</b><span>".$info->title."</span></a>";
                }else{
                    echo "<a href=\'javascript:;\'><span>".$text."</span><b>：</b><span>没有了</span></a>";
                }
            }?>'; // 
        return $parse;
    }
    /**
     * 友情链接标签
     * @param type $tag
     * @param type $content
     * @return string
     */
    public function tagFlink($tag,$content){
        $row = isset($tag['row']) && empty($tag['row']) ? $tag['row'] : 10;
        $name = isset($tag['field']) && empty($tag['field']) ? $tag['field'] :'field';
        $parse = '<?php ';
        $parse .= '$flink = \think\facade\Cache::get("flink");
                if (!$flink){
                    $flink = \app\common\model\Flink::limit(0,'.$row.')->order("sortrank desc")->select();
                    \think\facade\Cache::set("flink", $flink, 3600);
                }
                foreach($flink as $key=>$field){ 
                ?>';
        $parse .= $content;
        $parse .= '<?php }?>';
        return $parse;
    }
    
    public function tagField($tag,$content){
        return '';
    }
    public function tagSql($tag,$content){
        return '';
    }
}
