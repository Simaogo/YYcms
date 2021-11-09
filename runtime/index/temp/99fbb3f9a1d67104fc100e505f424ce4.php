<?php /*a:4:{s:43:"E:\WWW\tp6dedecms\/template/simao/index.htm";i:1636455290;s:5:"param";i:0;s:42:"E:\WWW\tp6dedecms\/template/simao/head.htm";i:1636455289;s:45:"E:\WWW\tp6dedecms\/template/simao/_search.htm";i:1636455288;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?php echo syscfg('cfg_webname'); ?></title>
<meta name="description" content="<?php echo syscfg('cfg_description'); ?>" />
<meta name="keywords" content="<?php echo syscfg('cfg_keywords'); ?>" />
<link rel="stylesheet" href="/static/css/jquery.fancybox-1.3.4.css">
<link rel="stylesheet" href="/static/css/animate.min.css">
<link rel="stylesheet" href="/static/css/yunu.css">
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/jquery.superslide.js"></script>
<script src="/static/js/jquery.fancybox-1.3.4.pack.js"></script>
<script src="/static/js/wow.min.js"></script>
<script src="/static/js/yunu.js"></script>
</head>
<body>
<div class="yunu-header">
  <div class="topbar">
    <div class="container">
      <ul>
        <?php $field = \think\facade\Cache::get("typeinfo_4");$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);$field["typeurl"] = $field["ispart"] == 2 && $field["sitepath"] ? $field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]); ?><li><a href='<?php echo htmlentities($field['typeurl']); ?>'><?php echo htmlentities($field['typename']); ?></a></li><?php $field = \think\facade\Cache::get("typeinfo_6");$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);$field["typeurl"] = $field["ispart"] == 2 && $field["sitepath"] ? $field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]); ?><li><a href='<?php echo htmlentities($field['typeurl']); ?>'><?php echo htmlentities($field['typename']); ?></a></li><?php $field = \think\facade\Cache::get("typeinfo_5");$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);$field["typeurl"] = $field["ispart"] == 2 && $field["sitepath"] ? $field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]); ?><li><a href='<?php echo htmlentities($field['typeurl']); ?>'><?php echo htmlentities($field['typename']); ?></a></li><?php ?>
      </ul>
      <span>欢迎光临<?php echo syscfg('cfg_companyname'); ?>官网！</span> </div>
  </div>
  <div class="container clearfix">
    <div class="logo wow zoomIn"><a href="/" title="<?php echo syscfg('cfg_companyname'); ?>"><img src="/static/images/b9f7213a35ef76017759784bd5ec169d.png" alt="<?php echo syscfg('cfg_companyname'); ?>"></a></div>
    <div class="text wow fadeIn"><strong>某某公司——粮食收储机械生产厂家</strong>专注生产粮食收储机械的大型高新技术企业</div>
    <div class="tel"><span>全国咨询热线：</span><strong><?php echo syscfg('cfg_tel'); ?></strong></div>
  </div>
</div>
<div class="yunu-nav">
  <div class="container">
    <div class="sc"> <a href="javascript:;"></a>
      <form action="<?php echo url('template/search'); ?>" method="post">
        <input type="text" name="q" placeholder="请输入关键词">
        <button type="submit">搜索</button>
      </form>
    </div>
    
        
    <ul class="clearfix">
      <li><a href="/"><span>网站首页</span></a></li>
	  <?php 
            $menuList = \think\facade\Cache::get("8924c77d03ac5aaac469c02ce79d58d2");
            $currid   = \think\facade\Cache::get("currid_8924c77d03ac5aaac469c02ce79d58d2");
            $selftypeid = 0;  
            $ArctypeModel=new \app\common\model\Arctype();
            foreach($menuList as $key => $field){
                    $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                    $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
                    $field["ischild"] = $ArctypeModel::where(["reid"=>$field["id"]])->find() ? 1 : 0;
                    $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮 
                    $pid = $field["id"];//嵌套标签typeid传值    
            ?>
      <li class="dropdown  <?php echo htmlentities($field['currentstyle']); ?>"> <a href="<?php echo htmlentities($field['typeurl']); ?>"  target="_self"><span><?php echo htmlentities($field['typename']); ?></span></a>
          <ul class="dropdown-box">
          	  <?php 
           
            if(isset($pid) && empty("0")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                $menuList =\app\common\model\Arctype::where($where)->limit(0,10)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("9205813979b12ed056fce19f67aa8112");
            }
            $currid   = \think\facade\Cache::get("currid_9205813979b12ed056fce19f67aa8112");
            
            foreach($menuList as $key => $field){
                   $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                   $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
		   $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                   $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
			<li><a href="<?php echo htmlentities($field['typeurl']); ?>"><span><?php echo htmlentities($field['typename']); ?></span></a></li><?php } 
                 ?>
           </ul>
      </li>
      <?php  unset($pid); };
        ?>
         </ul>
  </div>
</div>
<div class="yunu-slideBox">
  <div class="hd">
    <ul>
    </ul>
  </div>
  <div class="bd">
    <ul>
	 <?php $arclist = \think\facade\Cache::get("7d7a0b798471ed6608b55544546fa743");
                if(!$arclist){
                    $where=[];
                    $where[]=["arc.arcrank","=",0];
                    if(isset($pid)){
                        $typeid = $pid;
                    }
                    if(isset($selftypeid) && !empty("14")){
                        $typeid = $selftypeid != 0  ? $selftypeid:"14";
                    }
                    if(!empty("14")){
                        $typeid = "14";
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
                    if(!empty("0")){
                        $whereRaw = "FIND_IN_SET('0', flag)";
                    }
                    $arclist=\think\facade\Db::name("archives")
                        ->alias("arc")
                        ->join("dede_addonarticle add"," arc.id=add.aid","left")
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.pubdate desc")
                        ->limit(0,5)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("7d7a0b798471ed6608b55544546fa743",$arclist);  
                 } 
            $paranField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = mb_substr($field["title"],0,120);
                $field["litpic"] = $field["litpic"] ?$field["litpic"] :"__YYADMIN__/images/images.jpg";    
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"]) ? $field["redirecturl"] : \think\facade\Route::buildUrl("view",["aid"=>$field["id"]]);
            ?>			
      <li style="background-image: url(<?php echo htmlentities($field['picname']); ?>);"><a href="javascript:;"></a></li>
	 <?php }  
                   $field = isset($paranField) ? $paranField :""; 
                ?>
     </ul>
  </div>
</div>
<div class="yunu-sou-inner">
  <div class="container">
    <div class="yunu-sou clearfix">
      <div class="hot"> <strong>热门关键词：</strong> 
		<?php 
           
            if(isset($pid) && empty("0")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                $menuList =\app\common\model\Arctype::where($where)->limit(0,10)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("34a6c8512c58384e9e6dc55b3f43629a");
            }
            $currid   = \think\facade\Cache::get("currid_34a6c8512c58384e9e6dc55b3f43629a");
            
            foreach($menuList as $key => $field){
                   $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                   $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
		   $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                   $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>

		<a href='<?php echo htmlentities($field['typeurl']); ?>'><?php echo htmlentities($field['typename']); ?></a> 

		<?php } 
                 ?>
	  
	  </div>
      <div class="hform">
        <form action="<?php echo url('template/search'); ?>" method="post">
          <input type="text" name="q" placeholder="请输入关键字">
          <button type="submit"></button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="yunu-section">
  <div class="container">
    <div class="yunu-section-title wow zoomIn"> <span>产品中心</span>
      <p>环保科技型粮机 设备将取代传统粮机...</p>
    </div>
    <div class="clearfix">
      <div class="yunu-prd-l">
        <div class="tit">产品中心</div>
		   <?php 
            $menuList = \think\facade\Cache::get("0bf3f2e2216420c650084b13d9969aef");
            $currid   = \think\facade\Cache::get("currid_0bf3f2e2216420c650084b13d9969aef");
            $selftypeid = 0;  
            $ArctypeModel=new \app\common\model\Arctype();
            foreach($menuList as $key => $field){
                    $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                    $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
                    $field["ischild"] = $ArctypeModel::where(["reid"=>$field["id"]])->find() ? 1 : 0;
                    $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮 
                    $pid = $field["id"];//嵌套标签typeid传值    
            ?>
           <h3 onclick="javascript:top.location='<?php echo htmlentities($field['typeurl']); ?>';" style="background-image: url(/static/images/cp_ico0{dede:global name=itemindex runphp='yes'}@me=@me+1;{/dede:global}.gif)"><?php echo htmlentities($field['typename']); ?>   </h3>
		   <ul>
			    <?php 
           
            if(isset($pid) && empty("0")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                $menuList =\app\common\model\Arctype::where($where)->limit(0,10)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("98b4d48eb38933526233f165041d1c8b");
            }
            $currid   = \think\facade\Cache::get("currid_98b4d48eb38933526233f165041d1c8b");
            
            foreach($menuList as $key => $field){
                   $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                   $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
		   $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                   $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
			   <li><a href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a></li> <?php } 
                 ?>
		  </ul>
         <?php  unset($pid); };
        ?>  
		<div class="tel"> 全国服务热线： <strong><?php echo syscfg('cfg_tel'); ?></strong> <a  href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo syscfg('cfg_qq'); ?>&site=qq&menu=yes" target="_blank">在线咨询</a> </div>
      </div>
      <div class="yunu-prd-r">
        <div class="prd-b">
          <div class="bd">
            <ul class="picList">
              <?php $arclist = \think\facade\Cache::get("a1c7e42b9af4529e7e0bb5f2acc601c9");
                if(!$arclist){
                    $where=[];
                    $where[]=["arc.arcrank","=",0];
                    if(isset($pid)){
                        $typeid = $pid;
                    }
                    if(isset($selftypeid) && !empty("1")){
                        $typeid = $selftypeid != 0  ? $selftypeid:"1";
                    }
                    if(!empty("1")){
                        $typeid = "1";
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
                    if(!empty("0")){
                        $whereRaw = "FIND_IN_SET('0', flag)";
                    }
                    $arclist=\think\facade\Db::name("archives")
                        ->alias("arc")
                        ->join("dede_addonarticle add"," arc.id=add.aid","left")
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.pubdate desc")
                        ->limit(0,9)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("a1c7e42b9af4529e7e0bb5f2acc601c9",$arclist);  
                 } 
            $paranField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = mb_substr($field["title"],0,120);
                $field["litpic"] = $field["litpic"] ?$field["litpic"] :"__YYADMIN__/images/images.jpg";    
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"]) ? $field["redirecturl"] : \think\facade\Route::buildUrl("view",["aid"=>$field["id"]]);
            ?>		
              <li [field:global name=autoindex runphp='yes'](@me%3==0)? @me="style='margin-right:0'":@me='';[/field:global]> <a href="<?php echo htmlentities($field['arcurl']); ?>"  title="<?php echo htmlentities($field['title']); ?>">
                <div class="m img-center"><img src="/uploads/allimg/190815/1-1ZQ5211H5-lp.jpg" onerror="javascript:this.src='<?php echo htmlentities($field['picname']); ?>';" alt="<?php echo htmlentities($field['title']); ?>"></div>
                <div class="text"><?php echo htmlentities($field['title']); ?></div>
                </a> </li>
              <?php }  
                   $field = isset($paranField) ? $paranField :""; 
                ?>		
             
              
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="yunu-section yunu-honor">
  <div class="container clearfix">
    <div class="tel">全国服务热线：<?php echo syscfg('cfg_tel'); ?></div>
    <div class="lm">
      <div class="bd">
        <ul class="picList">
         <?php $arclist = \think\facade\Cache::get("7452e6cf983ce95ded53f131970af686");
                if(!$arclist){
                    $where=[];
                    $where[]=["arc.arcrank","=",0];
                    if(isset($pid)){
                        $typeid = $pid;
                    }
                    if(isset($selftypeid) && !empty("10")){
                        $typeid = $selftypeid != 0  ? $selftypeid:"10";
                    }
                    if(!empty("10")){
                        $typeid = "10";
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
                    if(!empty("0")){
                        $whereRaw = "FIND_IN_SET('0', flag)";
                    }
                    $arclist=\think\facade\Db::name("archives")
                        ->alias("arc")
                        ->join("dede_addonarticle add"," arc.id=add.aid","left")
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.pubdate desc")
                        ->limit(0,9)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("7452e6cf983ce95ded53f131970af686",$arclist);  
                 } 
            $paranField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = mb_substr($field["title"],0,120);
                $field["litpic"] = $field["litpic"] ?$field["litpic"] :"__YYADMIN__/images/images.jpg";    
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"]) ? $field["redirecturl"] : \think\facade\Route::buildUrl("view",["aid"=>$field["id"]]);
            ?>				
          <li> <a href="<?php echo htmlentities($field['arcurl']); ?>"  title="<?php echo htmlentities($field['title']); ?>">
            <div class="m img-center"><img src="<?php echo htmlentities($field['picname']); ?>" alt="<?php echo htmlentities($field['title']); ?>"></div>
            </a> </li>
            <?php }  
                   $field = isset($paranField) ? $paranField :""; 
                ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="yunu-section" style="overflow: hidden;">
  <div class="container">
    <div class="yunu-section-title wow zoomIn"> <span>应用案例</span>
      <p>某某粮食及全国各地粮库 见证着我们的匠心品质！</p>
    </div>
    <div class="yunu-case"> <a class="prev" href="javascript:void(0)"></a> <a class="next" href="javascript:void(0)"></a>
      <div class="bd">
        <ul>
          <?php $arclist = \think\facade\Cache::get("b1aa2af75f09d9a2a631ad64f1a75e15");
                if(!$arclist){
                    $where=[];
                    $where[]=["arc.arcrank","=",0];
                    if(isset($pid)){
                        $typeid = $pid;
                    }
                    if(isset($selftypeid) && !empty("2")){
                        $typeid = $selftypeid != 0  ? $selftypeid:"2";
                    }
                    if(!empty("2")){
                        $typeid = "2";
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
                    if(!empty("0")){
                        $whereRaw = "FIND_IN_SET('0', flag)";
                    }
                    $arclist=\think\facade\Db::name("archives")
                        ->alias("arc")
                        ->join("dede_addonarticle add"," arc.id=add.aid","left")
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.pubdate desc")
                        ->limit(0,9)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("b1aa2af75f09d9a2a631ad64f1a75e15",$arclist);  
                 } 
            $paranField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = mb_substr($field["title"],0,120);
                $field["litpic"] = $field["litpic"] ?$field["litpic"] :"__YYADMIN__/images/images.jpg";    
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"]) ? $field["redirecturl"] : \think\facade\Route::buildUrl("view",["aid"=>$field["id"]]);
            ?>			
          <li> <a href="<?php echo htmlentities($field['arcurl']); ?>"  title="<?php echo htmlentities($field['title']); ?>">
            <div class="m img-center"><img src="<?php echo htmlentities($field['picname']); ?>" alt="<?php echo htmlentities($field['title']); ?>"></div>
            <div class="text">
              <h4><?php echo htmlentities($field['title']); ?></h4>
              <p>[field:body function='cn_substr(@me,350)/]...</p>
              <img src="/static/images/case_btn.gif" alt=""> </div>
            </a> </li>
         
            <?php }  
                   $field = isset($paranField) ? $paranField :""; 
                ?>
        </ul>
      </div>
    </div>
    <div class="yunu-case-list">
      <div class="bd">
        <ul class="picList">
         <?php $arclist = \think\facade\Cache::get("23322333127957f3597e2c2cbfaf729a");
                if(!$arclist){
                    $where=[];
                    $where[]=["arc.arcrank","=",0];
                    if(isset($pid)){
                        $typeid = $pid;
                    }
                    if(isset($selftypeid) && !empty("12")){
                        $typeid = $selftypeid != 0  ? $selftypeid:"12";
                    }
                    if(!empty("12")){
                        $typeid = "12";
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
                    if(!empty("0")){
                        $whereRaw = "FIND_IN_SET('0', flag)";
                    }
                    $arclist=\think\facade\Db::name("archives")
                        ->alias("arc")
                        ->join("dede_addonarticle add"," arc.id=add.aid","left")
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.pubdate desc")
                        ->limit(0,20)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("23322333127957f3597e2c2cbfaf729a",$arclist);  
                 } 
            $paranField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = mb_substr($field["title"],0,120);
                $field["litpic"] = $field["litpic"] ?$field["litpic"] :"__YYADMIN__/images/images.jpg";    
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"]) ? $field["redirecturl"] : \think\facade\Route::buildUrl("view",["aid"=>$field["id"]]);
            ?>		
          <li><a href="<?php echo htmlentities($field['arcurl']); ?>"  title="<?php echo htmlentities($field['title']); ?>">
            <div class="m img-center"><img src="<?php echo htmlentities($field['picname']); ?>" alt="<?php echo htmlentities($field['title']); ?>"></div>
            <div class="text"><?php echo htmlentities($field['title']); ?></div>
            </a> </li>
          <?php }  
                   $field = isset($paranField) ? $paranField :""; 
                ?>
           
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="yunu-section yunu-ys">
  <div class="container">
    <div class="yunu-section-title wow zoomIn"> <span>核心竞争力</span>
      <p>砥砺奋进开拓创新 坚持不懈恪守品质</p>
    </div>
    <ul class="clearfix">
      <li>
        <div class="m img-center"><img src="/static/images/ys_pic01.jpg" alt=""></div>
        <div class="text">
          <h4>品牌与口碑</h4>
          <h5>13年品牌积淀</h5>
          <i></i>
          <p>13年深耕粮食收储机械生产领域，开拓与创新，荣幸地成为中储粮、各地粮库、面粉厂等全国各大粮食生产企业的合作客户，收获的好评如潮。</p>
        </div>
      </li>
      <li>
        <div class="m img-center"><img src="/static/images/ys_pic02.jpg" alt=""></div>
        <div class="text">
          <h4>设计与研发</h4>
          <h5>30+项国家专利</h5>
          <i></i>
          <p>研发团队，积极开拓创新，已获取30多项国家专利，其中新型研发的环保型粮食机械，彻底克服传统机械筛选不干净、筛量小、污染严重等难点问题。</p>
        </div>
      </li>
      <li>
        <div class="m img-center"><img src="/static/images/ys_pic03.jpg" alt=""></div>
        <div class="text">
          <h4>生产与品质</h4>
          <h5>10+年使用寿命</h5>
          <i></i>
          <p>8000㎡生产基地，拥有自动化生产设备30台，配备高精级检测设备，引进德国生产工艺及技术，产品已通过国家环保认证及质量管理认证，品质可鉴。</p>
        </div>
      </li>
      <li>
        <div class="m img-center"><img src="/static/images/ys_pic04.jpg" alt=""></div>
        <div class="text">
          <h4>服务与保障</h4>
          <h5>12小时售后响应</h5>
          <i></i>
          <p>承诺1年免费质保，终身维护，凡有质量问题，12小时内售后到位，提供远程技术指导或现场解决问题，零部件易损件有常规库存，后期运维更快捷。</p>
        </div>
      </li>
    </ul>
  </div>
</div>
<div class="yunu-section yunu-video"> <a href="#a" class="play"></a>
  <div style="display: none;">
    <iframe id="a" style="height: 535px;width: 100%;" frameborder="0" src='http://player.youku.com/embed/XNDIzMzA3MTkxNg==' allowfullscreen></iframe>
  </div>
  <div class="container clearfix">
    <div class="info">
      <h4>某某粮机<strong>环保粮机优选品牌</strong></h4>
      <ul class="clearfix">
		<?php $arclist = \think\facade\Cache::get("0e62a84217f078c544f5e3544640295e");
                if(!$arclist){
                    $where=[];
                    $where[]=["arc.arcrank","=",0];
                    if(isset($pid)){
                        $typeid = $pid;
                    }
                    if(isset($selftypeid) && !empty("11")){
                        $typeid = $selftypeid != 0  ? $selftypeid:"11";
                    }
                    if(!empty("11")){
                        $typeid = "11";
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
                    if(!empty("0")){
                        $whereRaw = "FIND_IN_SET('0', flag)";
                    }
                    $arclist=\think\facade\Db::name("archives")
                        ->alias("arc")
                        ->join("dede_addonarticle add"," arc.id=add.aid","left")
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.pubdate desc")
                        ->limit(0,20)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("0e62a84217f078c544f5e3544640295e",$arclist);  
                 } 
            $paranField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = mb_substr($field["title"],0,120);
                $field["litpic"] = $field["litpic"] ?$field["litpic"] :"__YYADMIN__/images/images.jpg";    
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"]) ? $field["redirecturl"] : \think\facade\Route::buildUrl("view",["aid"=>$field["id"]]);
            ?>	
        <li><a href="<?php echo htmlentities($field['arcurl']); ?>"  title="<?php echo htmlentities($field['title']); ?>"><?php echo htmlentities($field['title']); ?></a></li>
         <?php }  
                   $field = isset($paranField) ? $paranField :""; 
                ?> 		
    </ul>
    </div>
  </div>
</div>
<div class="yunu-section">
  <div class="container">
    <div class="yunu-section-title wow zoomIn"> <span>新闻百科</span>
      <p>某某环保科技型粮机 设备将取代传统粮机...</p>
    </div>
	<?php 
            $menuList = \think\facade\Cache::get("a3176a64be7f6b57fc2fa4790b1f91d3");
            $currid   = \think\facade\Cache::get("currid_a3176a64be7f6b57fc2fa4790b1f91d3");
            $selftypeid = 21;  
            $ArctypeModel=new \app\common\model\Arctype();
            foreach($menuList as $key => $field){
                    $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                    $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
                    $field["ischild"] = $ArctypeModel::where(["reid"=>$field["id"]])->find() ? 1 : 0;
                    $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮 
                    $pid = $field["id"];//嵌套标签typeid传值    
            ?>
    <div class="clearfix">
      <div class="yunu-news-1">
	 	
        <div class="yunu-news-title"><a href="<?php echo htmlentities($field['typeurl']); ?>" class="more">MORE+</a><?php echo htmlentities($field['typename']); ?></div>
         <?php $arclist = \think\facade\Cache::get("5b98cdd0ad1e4070fcd83c5d12ab0725");
                if(!$arclist){
                    $where=[];
                    $where[]=["arc.arcrank","=",0];
                    if(isset($pid)){
                        $typeid = $pid;
                    }
                    if(isset($selftypeid) && !empty("0")){
                        $typeid = $selftypeid != 0  ? $selftypeid:"0";
                    }
                    if(!empty("0")){
                        $typeid = "0";
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
                    if(!empty("0")){
                        $whereRaw = "FIND_IN_SET('0', flag)";
                    }
                    $arclist=\think\facade\Db::name("archives")
                        ->alias("arc")
                        ->join("dede_addonarticle add"," arc.id=add.aid","left")
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.pubdate desc")
                        ->limit(0,1)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("5b98cdd0ad1e4070fcd83c5d12ab0725",$arclist);  
                 } 
            $paranField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = mb_substr($field["title"],0,120);
                $field["litpic"] = $field["litpic"] ?$field["litpic"] :"__YYADMIN__/images/images.jpg";    
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"]) ? $field["redirecturl"] : \think\facade\Route::buildUrl("view",["aid"=>$field["id"]]);
            ?>		
        <dl>
          <dt class="img-center"><a href="<?php echo htmlentities($field['arcurl']); ?>"  title="<?php echo htmlentities($field['title']); ?>"><img src="/static/images/302f5fe1d8f3977c5f99900f6dc9c3d5.jpg" alt="<?php echo htmlentities($field['title']); ?>"></a></dt>
          <dd>
            <h4><a href="<?php echo htmlentities($field['arcurl']); ?>"  title="<?php echo htmlentities($field['title']); ?>"><?php echo htmlentities($field['title']); ?></a></h4>
            <span><?php echo htmlentities($field['pubdate']); ?></span> <i></i>
            <p>[field:description function='cn_substr(@me,450)/]...</p>
            <a href="<?php echo htmlentities($field['arcurl']); ?>"  title="<?php echo htmlentities($field['title']); ?>" class="more">查看详情</a> </dd>
        </dl>
		  <?php }  
                   $field = isset($paranField) ? $paranField :""; 
                ?> 
      </div>
	  <?php  unset($pid); };
        
            $menuList = \think\facade\Cache::get("5eae0b201d511ecf319b50b206a598eb");
            $currid   = \think\facade\Cache::get("currid_5eae0b201d511ecf319b50b206a598eb");
            $selftypeid = 22;  
            $ArctypeModel=new \app\common\model\Arctype();
            foreach($menuList as $key => $field){
                    $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                    $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
                    $field["ischild"] = $ArctypeModel::where(["reid"=>$field["id"]])->find() ? 1 : 0;
                    $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮 
                    $pid = $field["id"];//嵌套标签typeid传值    
            ?>
      <div class="yunu-news-2">
        <div class="yunu-news-title"><a href="<?php echo htmlentities($field['typeurl']); ?>" class="more">MORE+</a><?php echo htmlentities($field['typename']); ?></div>
        <div class="picMarquee-top">
          <div class="bd">
            <ul class="picList">
              <?php $arclist = \think\facade\Cache::get("f878e194e96562fe113cd443cb00cd9c");
                if(!$arclist){
                    $where=[];
                    $where[]=["arc.arcrank","=",0];
                    if(isset($pid)){
                        $typeid = $pid;
                    }
                    if(isset($selftypeid) && !empty("0")){
                        $typeid = $selftypeid != 0  ? $selftypeid:"0";
                    }
                    if(!empty("0")){
                        $typeid = "0";
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
                    if(!empty("0")){
                        $whereRaw = "FIND_IN_SET('0', flag)";
                    }
                    $arclist=\think\facade\Db::name("archives")
                        ->alias("arc")
                        ->join("dede_addonarticle add"," arc.id=add.aid","left")
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.pubdate desc")
                        ->limit(0,10)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("f878e194e96562fe113cd443cb00cd9c",$arclist);  
                 } 
            $paranField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = mb_substr($field["title"],0,120);
                $field["litpic"] = $field["litpic"] ?$field["litpic"] :"__YYADMIN__/images/images.jpg";    
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"]) ? $field["redirecturl"] : \think\facade\Route::buildUrl("view",["aid"=>$field["id"]]);
            ?>		
              <li> <a href="<?php echo htmlentities($field['arcurl']); ?>"  title="<?php echo htmlentities($field['title']); ?>">
                <div class="m img-center"><img src="<?php echo htmlentities($field['picname']); ?>" alt="<?php echo htmlentities($field['title']); ?>"></div>
                <div class="text">
                  <h4><?php echo htmlentities($field['title']); ?></h4>
                  <p>[field:description function='cn_substr(@me,450)/]...</p>
                </div>
                </a> </li>
			 <?php }  
                   $field = isset($paranField) ? $paranField :""; 
                ?> 
            </ul>
          </div>
        </div>
      </div>
    </div>
	<?php  unset($pid); };
        ?>
  </div>
</div>
<div class="yunu-section yunu-about">
  <div class="container">
    <div class="yunu-section-title wow zoomIn"> <span>关于我们</span> </div>
    <dl>
      <dd>
        <div class="m img-center"> <img src="/static/images/d044d6a61a87383fe67fe21c68c90fe1.jpg" alt="">
          <ul>
            <li> <strong>13<small>年</small></strong>
              <p>生产经验</p>
            </li>
            <li> <strong>80000<small>㎡</small></strong>
              <p>生产厂房</p>
            </li>
            <li> <strong>10<small>条</small></strong>
              <p>自动化生产线</p>
            </li>
            <li> <strong>30<small>项</small></strong>
              <p>研发专利</p>
            </li>
            <li> <strong>10<small>项</small></strong>
              <p>产品认证</p>
            </li>
          </ul>
        </div>
      </dd>
            <dt><p><?php 
           
            if(isset($pid) && empty("0")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                $menuList =\app\common\model\Arctype::where($where)->limit(0,10)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("baf68afcdc1411072f5225f15553bd03");
            }
            $currid   = \think\facade\Cache::get("currid_baf68afcdc1411072f5225f15553bd03");
            
            foreach($menuList as $key => $field){
                   $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                   $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
		   $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                   $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
				  [field:content function="cn_substr('@me',550)" /]
				  <?php } 
                 ?>......</p></dt>
      
    </dl>
    <div class="li">
	
	<?php 
           
            if(isset($pid) && empty("4")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                $menuList =\app\common\model\Arctype::where($where)->limit(0,10)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("026c1a3d27f54a16b6aa8117cb2417aa");
            }
            $currid   = \think\facade\Cache::get("currid_026c1a3d27f54a16b6aa8117cb2417aa");
            
            foreach($menuList as $key => $field){
                   $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                   $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
		   $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                   $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?><a href='<?php echo htmlentities($field['typeurl']); ?>'><?php echo htmlentities($field['typename']); ?></a> <?php } 
                 ?>
	
	</div>
    <div class="yunu-link" style="padding: 30px 0 10px;">
      <div class="container">
        <h4>友情链接 <small>/ LINKS</small></h4>
        <ul class="clearfix">
          		
         <?php $flink = \think\facade\Cache::get("flink");
                if (!$flink){
                    $flink = \app\common\model\Flink::limit(0,10)->order("sortrank desc")->select();
                    \think\facade\Cache::set("flink", $flink, 3600);
                }
                foreach($flink as $key=>$field){ 
                ?><li><?php echo htmlentities($field['link']); ?></li><?php } ?></li>
       
	   </ul>
      </div>
    </div>
    <!-- <div class="yunu-link" style="padding: 30px 0 10px;">
      <div class="container">
        <h4>城市地区 <small>/ city</small></h4>
        <ul class="clearfix">
                   <li><a href="http://170124.websitetemplate.cn/beijing.html">北京</a></li>
                    <li><a href="http://170124.websitetemplate.cn/dongcheng.html">东城</a></li>
                    <li><a href="http://170124.websitetemplate.cn/xicheng.html">西城</a></li>
                    <li><a href="http://170124.websitetemplate.cn/cy.html">朝阳</a></li>
                    <li><a href="http://170124.websitetemplate.cn/ft.html">丰台</a></li>
                    <li><a href="http://170124.websitetemplate.cn/shijingshan.html">石景山</a></li>
                    <li><a href="http://170124.websitetemplate.cn/haidian.html">海淀</a></li>
                    <li><a href="http://170124.websitetemplate.cn/mentougou.html">门头沟</a></li>
                    <li><a href="http://170124.websitetemplate.cn/fs.html">房山</a></li>
                    <li><a href="http://170124.websitetemplate.cn/tongzhou.html">通州</a></li>
                  </ul>
      </div>
    </div> -->
  </div>
</div>
<div class="yunu-footer">
  <div class="container clearfix">
    <div class="logo">
      <div class="l">
        <img src="/static/images/d40d6e3344cf09e87585ff3d5c6ee171.jpg" />      </div>
      <p>
        <?php echo syscfg('cfg_companyname'); ?>      </p>
      <ul>
        <li>
          <div class="m img-center">
            <img src="/static/images/c0c6fb7a49eaea715025c350a4365f4f.png" />          </div>
          <span>关注我们</span> </li>
        <li>
          <div class="m img-center">
            <img src="/static/images/c0c6fb7a49eaea715025c350a4365f4f.png" />          </div>
          <span>手机官网</span> </li>
      </ul>
    </div>
    <div class="info">
      <p>
        <?php echo syscfg('cfg_companyname'); ?>         © 版权所有</p>
      <p>全国服务热线：
        <?php echo syscfg('cfg_tel'); ?>      </p>
      <p>E-Mail：
        <?php echo syscfg('cfg_email'); ?>       </p>
      <p>公司地址：
         <?php echo syscfg('cfg_address'); ?>       </p>
      <p>备案号：<a href="http://www.beian.miit.gov.cn" target="_blank"> <?php echo syscfg('cfg_beian'); ?> </a>   <span>百度统计</span></p>
    </div>
    <ul class="nav">
		<?php 
           
            if(isset($pid) && empty("0")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                $menuList =\app\common\model\Arctype::where($where)->limit(0,10)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("6409901ee65e65df7f01a200362930a6");
            }
            $currid   = \think\facade\Cache::get("currid_6409901ee65e65df7f01a200362930a6");
            
            foreach($menuList as $key => $field){
                   $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                   $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
		   $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                   $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
		<li><a href='<?php echo htmlentities($field['typeurl']); ?>'><?php echo htmlentities($field['typename']); ?></a> </li>
		<?php } 
                 ?>
    </ul>
  </div>
</div>
<div class="kefu">
  <ul id="kefu">
    <li class="kefu-qq">
      <div class="kefu-main">
        <div class="kefu-left"> <a class="online-contact-btn" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo syscfg('cfg_qq'); ?>&site=qq&menu=yes" target="_blank"> <i></i>
          <p> QQ咨询 </p>
          </a> </div>
        <div class="kefu-right"></div>
      </div>
    </li>
    <li class="kefu-tel">
      <div class="kefu-tel-main">
        <div class="kefu-left"> <i></i>
          <p>联系电话 </p>
        </div>
        <div class="kefu-tel-right">
          <?php echo syscfg('cfg_tel'); ?>        </div>
      </div>
    </li>
    <li class="kefu-liuyan">
      <div class="kefu-main">
        <div class="kefu-left">
         <?php $field = \think\facade\Cache::get("typeinfo_5");$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);$field["typeurl"] = $field["ispart"] == 2 && $field["sitepath"] ? $field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]); ?><a href='<?php echo htmlentities($field['typeurl']); ?>'> <i></i>
            <p> 在线留言 </p>
            </a>
			<?php ?>
        </div>
        <div class="kefu-right"></div>
      </div>
    </li>
    <li class="kefu-weixin">
      <div class="kefu-main">
        <div class="kefu-left"> <i></i>
          <p> 微信扫一扫 </p>
        </div>
        <div class="kefu-right"> </div>
        <div class="kefu-weixin-pic">
          <img src="/static/images/c0c6fb7a49eaea715025c350a4365f4f.png" />        </div>
      </div>
    </li>
    <li class="kefu-ftop">
      <div class="kefu-main">
        <div class="kefu-left"> <a href="javascript:;"> <i></i>
          <p>返回顶部</p>
          </a> </div>
        <div class="kefu-right"></div>
      </div>
    </li>
  </ul>
</div>

<script>
    $('.yunu-nav li').eq(0).addClass('active');
    $('.yunu-slideBox').slide({titCell: '.hd ul', mainCell: '.bd ul', effect: 'fold', autoPlay: true, autoPage: '<li></li>'});
    $('.yunu-prd-l').slide({
        titCell: 'h3',
        targetCell: 'ul',
        defaultIndex: 0,
        effect: 'slideDown',
        delayTime: 300,
        // trigger: 'click'
    });
    $('.prd-t').slide({mainCell: '.bd ul', effect: 'fold'});
	
   /** $('.prd-b').slide({
        interTime: 50,
        mainCell: '.bd ul',
        effect: 'leftMarquee',
        autoPlay: true,
        vis: 3
    });**/
	
    $('.yunu-honor .lm').slide({
        interTime: 50,
        mainCell: '.bd ul',
        effect: 'leftMarquee',
        autoPlay: true,
        vis: 3
    });
    $('.yunu-case').slide({mainCell: '.bd ul', effect: 'leftLoop', autoPlay: true});
    $('.yunu-case-list').slide({
        interTime: 50,
        mainCell: '.bd ul',
        effect: 'leftMarquee',
        autoPlay: true,
        vis: 5
    });
    $('.yunu-video .play').fancybox({
        width: 960,
        height: 540,
        autoDimensions: false
    });
    $('.picMarquee-top').slide({
        mainCell: '.bd ul',
        autoPlay: true,
        effect: 'topMarquee',
        vis: 3,
        interTime: 50,
        trigger: 'click'
    });
</script>
</body>
</html>
