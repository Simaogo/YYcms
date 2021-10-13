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
        'close'               => ['attr' => 'time,format', 'close' => 0], //闭合标签，默认为不闭合
        'open'                => ['attr' => 'name,type', 'close' => 1], 
        'channel'             => ['typeid,type,order,row', 'alias' => 'iterate','close' => 1],   //typeid:栏目id|默认0,order:排序方式desc|asc|默认desc,row条数
        'channelartlist'      => ['typeid,order,row,pagesize', 'alias' => 'iterate','close' => 1],   //typeid:栏目id|默认0,order:排序方式desc|asc|默认desc,row条数
        'arclist'             => ['typeid,channelid,order,row,flag,titlelen', 'alias' => 'iterate','close' => 1],   //
        'list'                => ['order,row,flag,titlelen', 'alias' => 'iterate','close' => 1],   //
        'advert'              => ['group_id,order,row,titlelen', 'alias' => 'ad','close' => 1],  //广告
        'fieldset'            => ['itemname,autofield,notsend,type,isnull,islist,default,maxlength,page', 'alias' => 'iterate','close' => 1],  //自定义内容标签
        'include'            => ['attr' => 'filename', 'close' => 0],  //
    ];

    /**
     * 这是一个闭合标签的简单演示{demo:close time='$demo_time'/}
     */
    public function tagClose($tag)
    {
        $format = empty($tag['format']) ? 'Y-m-d H:i:s' : $tag['format'];
        $time = empty($tag['time']) ? time() : $tag['time'];
        $parse = '<?php ';
        $parse .= 'echo date("' . $format . '",' . $time . ');';
        $parse .= ' ?>';
        return $parse;
    }
    public function tagWebname($tag)
    {
        $format = empty($tag['webname']) ? '' : $tag[''];
        $time = empty($tag['time']) ? time() : $tag['time'];
        $parse = '<?php ';
        $parse .= 'echo date("' . $format . '",' . $time . ');';
        $parse .= ' ?>';
        return $parse;
    }
    /**
     * {include file="public/header" /}
     * @param type $tag
     * @return string
     */
    public function tagInclude($tag){
        $filename = empty($tag['filename']) ? '' : $tag['filename'];
        $templeta = '../templeta/' . syscfg(1,'cfg_df_style') .'/'. $filename;
        $parse = '{include}';
        return $parse;
    }
    /**
     * 这是一个非闭合标签的简单演示
     */
    public function tagOpen($tag, $content)
    {
        $type = empty($tag['level']) ? 1 : $tag['level']; // 这个type目的是为了区分类型，一般来源是数据库

        $parse = '<?php ';
        $parse .= '$test_arr=[[1,3,5,7,9],[2,4,6,8,10]];'; // 这里是模拟数据
        $parse .= '$__LIST__ = $test_arr[' . $type . '];';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }
    /**
     * channel 标签
     * @param type $tag
     * @param type $content
     * @return string
     */
    public function tagChannel($tag, $content){
        
        if(!isset($typeid)) {$typeid= empty($tag['typeid']) ? 0 : $tag['typeid'];};//栏目ID
        $type= empty($tag['type']) ? 'top' : $tag['type'];//类型
        $order= empty($tag['order']) ? "sortrank desc": $tag['order'];//排序
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
        $parseStr.='
                <?php 
            }
            ?>
        ';
        return $parseStr;
    }
    
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
            foreach($menuList as $index=>$field){
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
        //处理typeid
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
                $field["info"]=$field["description"]; //缩略图
                $field["litpic"]=explode(",",$field["litpic"]); //缩略图
                $field["arcurl"]=url("template/view",["aid"=>$field["aid"]])->build();
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
            $ArchivesModel=new \addons\travel\common\model\Archives();
            $arctList= $ArchivesModel->where($where) 
                                     ->order("sortrank '.$order.'")
                                     ->limit($pagesize,'.$row.')
                                     ->select();
  
            foreach($arctList as $index=>$field){
                
                $field["litpic"]=explode(",",$field["litpic"]); //缩略图
                $field["url"]=addons_url("template/view",["aid"=>$field["id"]]);
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
                    foreach($list as $index => $field){
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
    public function tagFieldset($tag,$content){
        $name = $tag["name"];
        $type = empty($tag['level']) ? 1 : $tag['level']; // 这个type目的是为了区分类型，一般来源是数据库
        $parse = '<?php ';
        $parse .= '$test_arr=[[1,3,5,7,9],[2,4,6,8,10]];'; // 这里是模拟数据
        $parse .= '$__LIST__ = $test_arr[' . $type . '];';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }
    

}
