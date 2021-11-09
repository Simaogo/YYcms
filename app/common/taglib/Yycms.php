<?php
namespace app\common\taglib;
use think\template\TagLib;
use think\facade\View;
use think\facade\Config;
class Yycms extends TagLib{
    /**
     * 定义标签列表
     */
    protected $tags   =  [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'channel'             => ['typeid,type,order,row,limit', 'alias' => 'iterate','close' => 1],   //typeid:栏目id|默认0,order:排序方式desc|asc|默认desc,row条数
        'channelartlist'      => ['typeid,order,row,pagesize,ishidden', 'alias' => 'iterate','close' => 1,'level'=>3],   //typeid:栏目id|默认0,order:排序方式desc|asc|默认desc,row条数
        'arclist'             => ['typeid,channelid,order,orderby,row,flag,titlelen,limit', 'alias' => 'arclist','close' => 1],   //
        'list'                => ['order,rderby,row,flag,titlelen', 'alias' => 'list','close' => 1],   //列表页
        'pagelist'            => ['listitem,listsize', 'alias' => 'list','close' => 0],   //分页标签
        'field'               => ['name,row,flag,titlelen', 'alias' => 'field','close' => 1],   //field
        'sql'                 => ['sql', 'alias' => 'sql','close' => 1],   //sql查询
        'type'                => ['typeid', 'alias' => 'sql','close' => 1],   //type查询栏目
        'myppt'              => ['typeid,order,row', 'alias' => 'myppy','close' => 1],  //广告管理
        'flink'               => ['row,type,name', 'alias' => 'flink', 'close' => 1],  //友情链接
        'prenext'             => ['get,pagelang','alias' => 'prenext','close' => 0],  //上一篇、下一篇
        'productimagelist'    => ['name,row', 'alias' => 'imagelist','close' => 1],  //解析图集
    ];
    /**
     * 栏目channel 标签
     * @param type $tag
     * @param type $content
     * @return string
     */
    public function tagChannel($tag, $content){
        $list_key = '';
        $where = [];
        $where[] = ["ishidden","=",0];
        foreach ($tag as $key =>$value){
            $list_key .= $key.$value;
        }
        if(input('tid')){
            $tid = input('tid');
        } else {
            $aid = input('aid');
            if($aid){
                $Arclist= \app\common\model\Arclist::find($aid);
                $tid = $Arclist->typeid;
             }
        }
        $reid   = empty($tid) && empty($aid) ? 0 : $tid;//内页栏目ID
        $type   = empty($tag['type']) ? 'son' : $tag['type'];//类型
        $typeid   = empty($tag['typeid']) ? "0" : $tag['typeid'];//栏目ID
        if($typeid){
             $typeid = strval($typeid);
            switch ($type) {
                case "top"://调顶级
                     $where[] = ["reid","=",0];
                break;
                case "self"://调自己
                     $where[] = ["id","in",$typeid];
                break;
                case "son": //调下级
                    $where[] = ["reid","in",$typeid];
                break;
                default :
                    $where[] = ["reid","in",$typeid];
            }
        } else {
            switch ($type) {
                case "son":
                    if($reid){ 
                        $where[] = ["reid","in",strval($reid)];     
                    } else {
                        $where[] = ["reid","in",$typeid];
                    }
                break;
                default :
                    $where[] = ["reid","=",$typeid];
            }
        }
        $order  = empty($tag['order']) ? "sortrank asc": $tag['order'];//排序
        $row    = empty($tag['row']) ? 10: $tag['row'];//条数
        $start = 0;
        if(!empty($tag['limit'])) {
            $limit = explode(',', $tag['limit']);
            $start = isset($limit[0]) ? $limit[0] : 0;
            $row = isset($limit[1]) ? $limit[1] : 10;
        }
        $currentstyle= empty($tag['currentstyle']) ? 'on': $tag['currentstyle'];//条数
        $list_key = md5($list_key.''.$typeid.''.$reid);
 
        $ArctypeModel=new \app\common\model\Arctype();
        $list = $ArctypeModel::select()->toArray();
        $menuList = $ArctypeModel->where($where)->order($order)->limit($start,$row)->select()->toArray();
        //没有下级则等同级
        if(!$menuList){
            $where = [];
            $where[] = ["ishidden","=",0];
            $ArctypeSelf = $ArctypeModel::find($reid);
            if($ArctypeSelf){
                if($ArctypeSelf->reid){
                    $where[] = ["reid","=",$ArctypeSelf->reid];
                    $menuList = $ArctypeModel->where($where)->order($order)->select()->toArray();
                }
            }    
        }
        //高亮栏目
        $currid = isset($tid) ? $ArctypeModel->currIds($list,$tid):array();
        \think\facade\Cache::set($list_key,$menuList);
        \think\facade\Cache::set('currid_'.$list_key,$currid);
        $parseStr = '<?php ';
        $parseStr.='
           
            if(isset($pid) && empty("'.$typeid.'")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                $menuList =\app\common\model\Arctype::where($where)->limit(0,'.$row.')->select();
               
            }else{
                $menuList = \think\facade\Cache::get("'.$list_key.'");
            }
            $currid   = \think\facade\Cache::get("currid_'.$list_key.'");
            
            foreach($menuList as $key => $field){
                   $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                   $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
		   $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                   $field["currentstyle"] = in_array($field["id"],$currid)?"'.$currentstyle.'":"";//栏目显示高亮
            ';
        $parseStr.= '?>';
        $parseStr.= $content;
        $parseStr.= '<?php } 
                 ?>';
        return $parseStr;
    }
    /**
     * 栏目三级嵌套
     * @param type $tag
     * @param type $content
     * @return string
     */
    public function tagChannelartlist($tag, $content){
       $order  = empty($tag['order']) ? "sortrank asc": $tag['order'];//排序
       $row    = empty($tag['row']) ? 10: $tag['row'];//条数 
       $type = empty($tag['type']) ? 'top' : $tag['type'];//类型
       $ishidden = empty($tag['ishidden']) ? '0' : $tag['ishidden'];//是否显示隐藏栏目
       $list_key = '';
       $selftypeid = 0;//判断是否是调用当前栏目,0否,>0则是调用当前栏目
        foreach ($tag as $key =>$value){
            $list_key .= $key.$value;
        }
        $tid = 0;
        if(input('tid')){
            $tid = input('tid');
        } else {
            $aid = input('aid');
            $Arclist= \app\common\model\Arclist::find($aid);
            $tid = $aid ? $Arclist->typeid :0;
        }
        //高亮栏目ID
        $currentstyle = empty($tag['currentstyle']) ? 'on': $tag['currentstyle'];//条数
        
        $ArctypeModel=new \app\common\model\Arctype();
        $currid = isset($tid) ? $ArctypeModel->currIds($ArctypeModel::select(),$tid):array();
        $where = [];
        $type   = empty($tag['type']) ? 'son' : $tag['type'];//类型
        $typeid   = empty($tag['typeid']) ? "0" : $tag['typeid'];//栏目ID
        if($typeid){
           if($tag['typeid']=='top'){
               $typeid = '0';
               $type =  'top';
            }
            //解析5,5 这种情况
            if( strstr($typeid,',') && trim( trim( strstr($typeid,','), ',' ),' ') == trim( trim(strstr($typeid,',',true), ','),' ')){
                $type ='self';
            }
            switch ($type) {
                case "top"://调顶级
                     $where[] = ["reid","=",$typeid];
                break;
                case "self"://调自己
                     $where[] = ["id","in",$typeid];
                break;
                case "son": //调下级
					
                    $where[] = ["reid","in",$typeid];
                break;
                default :
                    $where[] = ["reid","in",$typeid];
            }
        } else {
            $where[] = ["reid","=",0];
        }
        if(isset($tag['typeid']) && $tag['typeid']!='top'){
            $typeAarr = explode(',', $tag['typeid']);
            if(count($typeAarr) == 2 && $typeAarr[1]==0 ){
                $tag['typeid'] = !empty($tag['typeid']) && $typeAarr[1] == 0 ? $typeAarr[0] : $tag['typeid'];//栏目ID
                $selftypeid = $typeAarr[0];
                $row = 1;
				$where = [];
                $where[] = ["id","in",$selftypeid];
            }
        }
        $where[] = ["ishidden","in",$ishidden];
        $menuList = $ArctypeModel->where($where)->order($order)->limit(0,$row)->select()->toArray();
        $list_key = md5($list_key);
        \think\facade\Cache::set($list_key,$menuList);
        \think\facade\Cache::set('currid_'.$list_key,$currid);
        $parseStr = '<?php ';
        $parseStr.='
            $menuList = \think\facade\Cache::get("'.$list_key.'");
            $currid   = \think\facade\Cache::get("currid_'.$list_key.'");
            $selftypeid = '.$selftypeid.';  
            $ArctypeModel=new \app\common\model\Arctype();
            foreach($menuList as $key => $field){
                    $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                    $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
                    $field["ischild"] = $ArctypeModel::where(["reid"=>$field["id"]])->find() ? 1 : 0;
                    $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"'.$currentstyle.'":"";//栏目显示高亮 
                    $pid = $field["id"];//嵌套标签typeid传值    
            ';
        $parseStr.= '?>';
        $parseStr.= $content;
        $parseStr.='<?php  unset($pid); };
        ?>';
        
        return $parseStr;
    }
    public function tagArclist($tag, $content){
        $list_key = $this->getListKey($tag); //缓存键
        $titlelen = empty($tag['titlelen']) ? 120: intval($tag['titlelen'])*2;//标题长度
        $typeid = empty($tag['typeid']) ?  0 : $tag['typeid'];//栏目ID
        $orderby = empty($tag['orderby']) ? "weight desc,pubdate desc": $tag['orderby'] .' desc';//排序兼容orderby
        $order =  !empty($tag['order']) && empty($tag["orderby"]) ? $tag['order']: $orderby;//排序
        $limit = empty($tag['row']) ? 15: $tag['row'];//条数
        $page = 0;
        if(isset($tag['limit']) && !empty($tag['limit'])){
            $limitArr = explode(',', $tag['limit']);
            $page = $limitArr[0];
            $limit =  $limitArr[1];
        }
        
        $flag= !empty($tag['flag'])?$tag['flag']:0; //flag
        $channelid = isset($tag['channelid']) && !empty($tag['channelid']) ? $tag['channelid'] : 1;//模型ID
        $ChanneltypeModel = new \app\common\model\Channeltype();
        $Channeltype=$ChanneltypeModel->find($channelid);
        $parseStr = '<?php ';
        $parseStr .= '$arclist = \think\facade\Cache::get("'.$list_key.'");';
        $parseStr .= '
                if(!$arclist){
                    $where=[];
                    $where[]=["arc.arcrank","=",0];
                    if(isset($pid)){
                        $typeid = $pid;
                    }
                    if(isset($selftypeid) && !empty("'.$typeid.'")){
                        $typeid = $selftypeid != 0  ? $selftypeid:"'.$typeid.'";
                    }
                    if(!empty("'.$typeid.'")){
                        $typeid = "'.$typeid.'";
                    }
                    
                    //查找下级栏目
                    $typeList = \app\common\model\Arctype::select();
                    $typeidArr =[];
                    if(isset($typeid)){
                        if($typeList && $typeid){
                            foreach (explode(",",$typeid) as  $val){
                                $typeidArr = array_merge($typeidArr, \app\common\model\Arctype::childrenIds($typeList, $val));
                            }
                            $typeid = trim(array_reduce($typeidArr, function($carry, $item){
                                    return $carry . ",".$item;
                                }), ",");
                        }
                        
                        if($typeid) $where[]=["arc.typeid","in",$typeid];

                    }
                    $whereRaw = "";
                    if(!empty("'.$flag.'")){
                        $whereRaw = "FIND_IN_SET(\''.$flag.'\', flag)";
                    }
                    $arclist=\think\facade\Db::name("archives")
                        ->alias("arc")
                        ->join("'.$Channeltype->addtable.' add"," arc.id=add.aid","left")
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.'.$order.'")
                        ->limit('.$page.','.$limit.')
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("'.$list_key.'",$arclist);  
                 } ';
        $parseStr.='
            $paranField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = mb_substr($field["title"],0,'.$titlelen.');
                $field["litpic"] = $field["litpic"] ?$field["litpic"] :"__YYADMIN__/images/images.jpg";    
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"]) ? $field["redirecturl"] : \think\facade\Route::buildUrl("view",["aid"=>$field["id"]]);
            ';
        $parseStr.='?>';
        $parseStr.=$content;
        $parseStr.=' <?php }  
                   $field = isset($paranField) ? $paranField :""; 
                ?>';
        return $parseStr;
    }
    public function tagList($tag, $content){
        $pagesize = empty($tag['pagesize']) ? 10: $tag['pagesize'];//分页
        $titlelen = empty($tag['tilelen']) ? 120: intval($tag['tilelen'])*2;//标题长度
        $orderby = empty($tag['orderby']) ? "weight desc,pubdate desc": $tag['orderby'] .' desc';//排序兼容orderby
        $order =  !empty($tag['order']) && empty($tag["orderby"]) ? $tag['order']: $orderby;//排序
        $page = empty(input('page')) ? 1 : input('page');
        $where=[];
        $where[]=["arc.arcrank","=",0];
        if(input('q')){
            $keyword = trim(input('q'),' ');
            $search_key = md5($keyword);
            $search_key_page  = md5($keyword) . '_page';
            $where[] = ['title','like', '%'.$keyword.'%'];
            $list = \think\facade\Db::name("archives") ->alias("arc")
                            ->where($where)
                            ->order($order)
                            ->limit(($page-1)*$pagesize,$pagesize)
                            ->select();
							
            $page = \think\facade\Db::name("archives") ->alias("arc")
                            ->where($where)
                            ->order($order)
                            ->limit(($page-1)*$pagesize,$pagesize)
                            ->paginate(['list_rows'=>$pagesize])
                            ->render();
            
            \think\facade\Cache::set($search_key,$list->toArray());
            \think\facade\Cache::set($search_key_page,$page);
            
            $parseStr = '<?php ';
            $parseStr .= '$list = \think\facade\Cache::get("'.$search_key.'");';
            $parseStr.=' 
                        foreach($list as $key =>$field) {
                            $field["title"] = mb_substr($field["title"],0,'.$titlelen.');
                            $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"]) ? $field["redirecturl"] : \think\facade\Route::buildUrl("view",["aid"=>$field["id"]]);
                            $field["litpic"] = $field["litpic"] ?$field["litpic"] :"__STATIC__/images/images.jpg";
                            $field["picname"] = $field["litpic"];//缩略图
                       ';

            $parseStr.='?>';
            $parseStr .= $content;
            $parseStr.=' <?php }
                      ?>';
            return $parseStr;
        } else {
            $typeid = input("tid");
            $list_key = 'list_tid_'.$typeid.'_'.$page;
            $page_key = 'list_'.$typeid.'_page'.'_'.$page;
             //查找下级栏目
            $typeList = \app\common\model\Arctype::select();
            $typeidArr =[];
            if($typeList && $typeid){
                $typeidArr = array_merge($typeidArr, \app\common\model\Arctype::childrenIds($typeList, $typeid));
                $typeid = trim(array_reduce($typeidArr, function($carry, $item){
                        return $carry . ','.$item;
                    }), ',');
            }
            $where[]=["arc.typeid","in",$typeid];
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
                            ->order($order)
                            ->limit(($page-1)*$pagesize,$pagesize)
                            ->select();
        $page = \think\facade\Db::name("archives") ->alias("arc")
                            ->where($where)
                            ->order($order)
                            ->limit(($page-1)*$pagesize,$pagesize) ->paginate(['list_rows'=>$pagesize])->render();
		$list = $list ? $list ->toArray(): array();
        \think\facade\Cache::set($list_key,$list);
        \think\facade\Cache::set($page_key,$page);
        $parseStr = '<?php ';
        $parseStr .= '$list = \think\facade\Cache::get("'.$list_key.'");';
        $parseStr.=' 
                    foreach($list as $key =>$field) {
                        $field["title"] = substr($field["title"],0,'.$titlelen.');
                        $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"]) ? $field["redirecturl"] : \think\facade\Route::buildUrl("view",["aid"=>$field["id"]]);
                        $field["litpic"] = $field["litpic"] ?$field["litpic"] :"__STATIC__/images/images.jpg";
                        $field["picname"] = $field["litpic"];//缩略图
                        $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                   ';
        
        $parseStr.='?>';
        $parseStr .= $content;
        $parseStr.=' <?php }  
                  ?>';
        return $parseStr;
    }
   /**
    * 分页输出
    * @param type $tag
    * @param type $content
    * @return string
    */
    public function tagPagelist($tag,$content){
	$page = empty(input('page')) ? 1 :input('page');
        if(input('q')){
            $keyword = trim(input('q'),' ');
            $page_key = md5($keyword).'_page_'.$page;
        } else {
            $typeid = input("tid");
            if(!input("tid")) return '';
            $page_key = 'list_'.$typeid.'_page_'.$page;
        }
        $parseStr = '<?php ';
        $parseStr .= '$page = \think\facade\Cache::get("'.$page_key.'"); ';
        $parseStr.=' ?>';
        $parseStr.='{$page|raw}';
        return $parseStr;
    }
    /**
     * 广告管理
     * @param type $tag
     * @param type $content
     * @return string
     */
    public function tagMyppt($tag,$content){
        $typeid= empty($tag['typeid']) ? 1 : $tag['typeid'];//组ID
        $order= empty($tag['order']) ? "orderid asc": $tag['order'];//排序
        $row= empty($tag['row']) ? 10: $tag['row'];//条数    
        $parseStr = '<?php ';
        $parseStr.='
            $where = [];
            $where[] = ["typeid","=",'.$typeid.'];
            $MyppModel = new \app\common\model\Myppt();
            $list=$MyppModel->where($where)->select()->toArray();
                    foreach($list as $key => $field){
                        $field["picname"] = $field["pic"];
                        $field["arcurl"]  =$field["url"];
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
     * 上一篇、下一篇
     * @param type $tag
     * @param type $content
     * @return string
     */
     public function tagPrenext ($tag,$content){
        $getparam = $tag["get"];
	$lang = empty($tag['pagelang']) ? 'zh' : $tag['pagelang'];
        if(!$getparam) return '';
        $parse = '<?php ';
        $parse .= '$aid = input("aid");
            if($aid){
                $Arclist = \app\common\model\Arclist::find($aid);
                $where = [];
                $where[]=["arcrank","=",0];
                $where[] = ["typeid","=",$Arclist->typeid];
                if("'.$getparam.'"=="pre"){
                    $where[] = ["id","<",$aid];
                    $text = "'.$lang.'"=="zh"?"上一篇":"Pre";
                 }else{
                    $where[] = ["id",">",$aid];
                    $text = "'.$lang.'"=="zh"?"下一篇":"Next";
                }
                $info = \app\common\model\Arclist::where($where)->limit(1)->find();
                if($info){
                    $url =  in_array("j",explode(",",$info->flag)) && !empty($info->redirecturl) ? $info->redirecturl : \think\facade\Route::buildUrl("view",["aid"=>$info->id]);
                    echo "<a href =\'".$url."\'><span>".$text."</span><b>：</b><span>".$info->title."</span></a>";
                }else{
                    $prenextNull = "'.$lang.'"=="zh"?"没有了":"null";
                    echo "<a href=\'javascript:;\'><span>".$text."</span><b>：</b><span>".$prenextNull."</span></a>";
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
        $parse .= '<?php } ?>';
        return $parse;
    }
    public function tagField($tag,$content){
        return '';
    }
    public function tagType($tag,$content){
        $typeid = empty($tag['typeid']) ? 0 : $tag['typeid'];
        $typeinfo = \app\common\model\Arctype::find($typeid);
        if(!$typeinfo) return '';
        $typeinfo = $typeinfo->toArray();
        $typeKey = 'typeinfo_'.$typeid;
        \think\facade\Cache::set($typeKey,$typeinfo);
        $parse = '<?php ';
        $parse .= '$field = \think\facade\Cache::get("'.$typeKey.'");';
        $parse .= '$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);';
        $parse .= '$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);';
        $parse .= '$field["typeurl"] = $field["ispart"] == 2 && $field["sitepath"] ? $field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]); ?>';
        $parse .= $content;
        $parse .= '<?php ?>';
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
        $parse .= '$fieldTem = isset($field) && $field ? $field:"";';
        $parse .= '{volist name="__LIST__" id="field"}';
        $parse .= $content;
       $parse .= '{/volist}';
        return $parse;
    }
    public function tagProductimagelist($tag, $content)
    {
        $type = empty($tag['type']) ? 0 : 1; // 
        $name = empty($tag['name']) ? 'field' :$tag['name']; 
        $parse = '<?php 
                if(isset($yy["field"]["imgurls"]) && is_array($yy["field"]["imgurls"])){
                    $field = [];
                    foreach($yy["field"]["imgurls"] as $key => $val){
                    $field["imgsrc"] = $val;
                    $field["text"] = $yy["field"]["title"];
                ?>';
        $parse .= $content;
        $parse .= '<?php } } ?>';

        return $parse;
    }
    /**
     * 缓存键
     * @param type $tag
     * @return string
     */
    public function getListKey($tag){
        $list_key = '';
        foreach ($tag as $key =>$value){
            $list_key .= $key.$value;
        }
        return md5($list_key);
    }
}
