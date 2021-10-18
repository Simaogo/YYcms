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
        'arclist'             => ['typeid,channelid,order,row,flag,titlelen,limit', 'alias' => 'arclist','close' => 1],   //
        'list'                => ['order,row,flag,titlelen', 'alias' => 'list','close' => 1],   //列表页
        'pagelist'            => ['listitem,listsize', 'alias' => 'list','close' => 0],   //分页标签
        'field'               => ['name,row,flag,titlelen', 'alias' => 'field','close' => 1],   //field
        'sql'                 => ['sql', 'alias' => 'sql','close' => 1],   //sql查询
        'type'                => ['typeid', 'alias' => 'sql','close' => 1],   //type查询栏目
        'advert'              => ['group_id,order,row,titlelen', 'alias' => 'ad','close' => 1],  //广告管理
        'flink'               => ['row,type,name', 'alias' => 'flink', 'close' => 1],  //友情链接
        'prenext'             => ['attr' => 'get','close' => 0],  //上一篇、下一篇
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
                    $field["typeurl"] = "/list/tid/".$field["id"];
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
                $field["typeurl"] = "/list/tid/".$field["id"];
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
        $list_key = '';
        foreach ($tag as $key =>$value){
            $list_key .= $key.$value;
        }
        $titlelen = empty($tag['titlelen']) ? 120: intval($tag['titlelen'])*2;//标题长度
        $list_key = md5($list_key);
        if(!\think\facade\Cache::get($list_key)) {
            $typeid = isset($tag['typeid'])&& !empty($tag['typeid']) ?  explode(',',$tag['typeid']) : '';//栏目ID
            //查找下级栏目
            $typeList = \app\common\model\Arctype::select();
            $typeidArr =[];
            if($typeList && $typeid){
                foreach ($typeid as  $val){
                    $typeidArr = array_merge($typeidArr, \app\common\model\Arctype::childrenIds($typeList, $val));
                }
                $typeid = trim(array_reduce($typeidArr, function($carry, $item){
                        return $carry . ','.$item;
                    }), ',');
            } 
            $order= empty($tag['order']) ? "sortrank asc": $tag['order'];//排序
            $limit = empty($tag['row']) ? 10: $tag['row'];//条数
            $page = 0;
            if(isset($tag['limit']) && !empty($tag['limit'])){
                $limitArr = explode(',', $tag['limit']);
                $page = $limitArr[0];
                $limit =  $limitArr[1];
            }
            $flag= !empty($tag['flag'])?$tag['flag']:''; //flag
            $whereRaw = '';
            if($flag){
                $whereRaw = "FIND_IN_SET('$flag', flag)";
            }
            $channelid = isset($tag['channelid']) && !empty($tag['channelid']) ? $tag['channelid'] : 1;//模型ID
            $where=[];
            $where[]=["arc.arcrank","=",0];
            if($typeid){
               $where[]=["arc.typeid","in","'.$typeid.'"];
            }
            $ChanneltypeModel = new \app\common\model\Channeltype();
            $Channeltype=$ChanneltypeModel->find($channelid);
            $arclist=\think\facade\Db::name("archives")
                                ->alias("arc")
                                ->join($Channeltype->addtable." add"," arc.id=add.aid","left")
                                ->where($where)
                                ->where($whereRaw)
                                ->order("arc.".$order)
                                ->limit($page,$limit)
                                ->select()
                                ->toArray(); 
            \think\facade\Cache::set($list_key,$arclist);
        }
        $parseStr = '<?php ';
        $parseStr .= '$arclist = \think\facade\Cache::get("'.$list_key.'");';
        $parseStr.='
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = substr($field["title"],0,'.$titlelen.');
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"])?$field["redirecturl"] : "/view/aid/".$field["id"];
            ';
        $parseStr.='?>';
        $parseStr.=$content;
        $parseStr.=' <?php } ?>';
        return $parseStr;
    }
   public function tagList($tag, $content){
        
        $pagesize = empty($tag['pagesize']) ? 15: $tag['pagesize'];//分页
        $titlelen = empty($tag['tilelen']) ? 120: intval($tag['tilelen'])*2;//标题长度
        $page = empty(input('page')) ? 0 :input('page');
        $where=[];
        $where[]=["arc.arcrank","=",0];
        if(input('q')){
            $keyword = input('q');
            $where[] = ['title','%like%', trim($keyword,' ')];
            $list_key  = md5($keyword);
        } else {
            $typeid=input("tid");
            $where[]=["arc.arcrank","=",$typeid];
            $list_key = 'list_tid_'.$typeid.'_page_'.$page;
            if(!input("tid")) return '';
        }
        $ArctypeModel = new \app\common\model\Arctype();
        $Arctype = $ArctypeModel::find($typeid);
        $ChanneltypeModel = new \app\common\model\Channeltype();
        $Channeltype = $ChanneltypeModel->find($Arctype->channeltype);
        $Channeltype=$ChanneltypeModel->find($Channeltype->id);
        $list = \think\facade\Db::name("archives")
                            ->alias("arc")
                            ->join($Channeltype->addtable." add"," arc.id=add.aid","left")
                            ->where($where)
                            ->order("sortrank asc,pubdate asc")
                            ->limit($page,$pagesize)
                            ->select()
                            ->toArray();
        $page = \think\facade\Db::name("archives")
                            ->alias("arc")
                            ->join($Channeltype->addtable." add"," arc.id=add.aid","left")
                            ->where($where)
                            ->paginate(['list_rows'=>$pagesize])
                            ->render();
        $page_key = 'list_'.$typeid.'_page';
        \think\facade\Cache::set($list_key,$list);
        \think\facade\Cache::set($page_key,$page);
        
        $parseStr = '<?php ';
        $parseStr .= '$list = \think\facade\Cache::get("'.$list_key.'");';
       // $parseStr .= '$page = \think\facade\Cache::get("'.$page_key.'");';
        $parseStr.=' foreach($list as $key =>$field) {
                        $field["title"] = substr($field["title"],0,'.$titlelen.');
                        $field["arcurl"] = "/view/aid/".$field["id"];
                        $field["picname"] = $field["litpic"];//缩略图
                        $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                   ';
        
        $parseStr.='?>';
        $parseStr .= $content;
        $parseStr.=' <?php } ?>';
        return $parseStr;
    }
   /**
    * 分页输出
    * @param type $tag
    * @param type $content
    * @return string
    */
    public function tagPagelist($tag,$content){
        $typeid=input("tid");
        if(!input("tid")) return '';
        $page = \think\facade\Cache::get("list_".$typeid.'_page');
        return $page;
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
    public function tagType($tag,$content){
        $typeid = empty($tag['typeid']) ? 0 : $tag['typeid'];
        $typeinfo = \app\common\model\Arctype::find($typeid);
        $typeKey = 'typeinfo_'.$typeid;
        \think\facade\Cache::set($typeKey,$typeinfo);
        $parse = '<?php ';
        $parse .= '$__LIST__ = \think\facade\Cache::get("'.$typeKey.'");';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="field"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }
    public function tagSql($tag,$content){
        if(empty($tag['sql'])) return '';
        $sql = $tag['sql'];
        $data = \think\facade\Db::query($sql);
        $sql_key = md5($sql);
        \think\facade\Cache::set($sql_key,$data);
        $parse = '<?php ';
        $parse .= '$__LIST__ = \think\facade\Cache::get("'.$sql_key.'");';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="field"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }
}
