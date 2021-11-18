<?php /*a:4:{s:43:"E:\WWW\tp6dedecms\/template/simao/index.htm";i:1637112631;s:5:"param";i:0;s:42:"E:\WWW\tp6dedecms\/template/simao/head.htm";i:1637113246;s:44:"E:\WWW\tp6dedecms\/template/simao/footer.htm";i:1637056096;}*/ ?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
 <title><?php echo syscfg('cfg_webname'); ?></title>
<meta name="description" content="<?php echo syscfg('cfg_description'); ?>" />
<meta name="keywords" content="<?php echo syscfg('cfg_keywords'); ?>" />
    <link rel="stylesheet" href="/skin/css/main.css"/>
    <link rel="stylesheet" href="/skin/css/media.css"/>
    <link rel="stylesheet" href="/skin/css/swiper-3.4.2.min.css"/>
    <script src="/skin/js/jquery-2.1.1.js"></script>
    <script src="/skin/js/swiper-3.4.2.min.js"></script>
    <script src="/skin/js/fastclick.js"></script>
    <!--[if IE]>
    <script src="/skin/js/html5shiv.min.js"></script>
    <script src="/skin/js/respond.min.js"></script>
    <![endif]-->
    <script src="/skin/js/main.js"></script>
</head>
<body>
<div class="header">
    <div class="head-top bg15 pc-show">
        <div class="w1388 clear">
            <div class="fl"><?php echo syscfg('cfg_gg'); ?></div>
            <div class="fr hotLine"><span class="span1">全国咨询热线：</span><span class="span2"><?php echo syscfg('cfg_tel'); ?></span></div>
        </div>
    </div>
    <div class="head-mid">
        <div class="head-con">
            <div class="w1388 relative clear">
                <h1 class="logo"><a href="/"><img src="/skin/images/logo.png" alt=""/></a></h1>
                <div class="menu-box fr">
                    <div class="top-search">
                        <div class="search-btn"></div>
                        <div class="search-nr">
                            <div class="search-nr-wap">
                                <div class="search-close"></div>
                                <form method="get" action="<?php echo url('template/search'); ?>">
								      <input type="hidden" name="kwtype" value="0" />
                                    <input class="text" name="q" type="text" placeholder="search"/>
                                    <input class="sbmit" type="submit" value=""/>
                                </form>
                            </div>
                        </div>
                    </div>
                    <ul class="clear menu-box-ul">
                        <li <?php if(!isset($yy)): ?> class="active" <?php endif; ?> ><a class="nav-yi" href="/">网站首页</a></li>
                        <?php 
            $menuList = \think\facade\Cache::get("c795625b860b296ebad9605005153e04");
            $currid   = \think\facade\Cache::get("currid_c795625b860b296ebad9605005153e04");
            $selftypeid = 0;  
            $ArctypeModel=new \app\common\model\Arctype();
            foreach($menuList as $key => $field){
                    $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                    $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
                    $field["ischild"] = $ArctypeModel::where(["reid"=>$field["id"]])->find() ? 1 : 0;
                    $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"active":"";//栏目显示高亮 
                    $pid = $field["id"];//嵌套标签typeid传值    
            ?>
			<li class="<?php echo htmlentities($field['currentstyle']); ?>">
                            <a class="nav-yi" href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a>
                            <?php if($field['ischild']): ?>
                              <div class="nav-er-box relative">
                                  <div class="nav-tap">
                                        <?php 
           
            if(isset($pid) && empty("0")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                $menuList =\app\common\model\Arctype::where($where)->limit(0,10)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("1aa5a28e21cef8fd018395c76961644d");
            }
            $currid   = \think\facade\Cache::get("currid_1aa5a28e21cef8fd018395c76961644d");
            
            foreach($menuList as $key => $field){
                   $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                   $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
		   $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                   $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
                                         <div class="nav-er-list">
                                          <a class="nav-er" href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a>
                                         </div>
                                        <?php } 
                    unset($field);
                 ?>
                                        </div>
                                     </div>
                               <?php endif; ?>
                         </li>
                         <?php  unset($pid); 
                         } 
                        unset($field);
                     ?> 
                     </ul>
                </div>
                <!--<a class="language" href="#">EN</a>-->
            </div>
        </div>
    </div>
    <div id="menu-handler" class="menu-handler">
        <span class="burger burger-1 trans"></span>
        <span class="burger burger-2 trans-fast"></span>
        <span class="burger burger-3 trans"></span>
    </div>
</div>
<!--banner-->
<script type="text/javascript">
    var img1='<meta content="telephone=no" name="format-detection">';
    $('head').append(img1);
</script><div class="banner img100">
    <div class="swiper-container">
        <div class="swiper-wrapper">
        <?php 
            $where = [];
            $where[] = ["typeid","=",1];
            $MyppModel = new \app\common\model\Myppt();
            $list=$MyppModel->where($where)->select()->toArray();
                    foreach($list as $key => $field){
                        $field["picname"] = $field["pic"];
                        $field["arcurl"]  =$field["url"];
                        ?>
		<div class="swiper-slide">
			<div class="pc-show"><img src="<?php echo htmlentities($field['picname']); ?>"/></div>
			<div class="phone-show"><img src="<?php echo htmlentities($field['picname']); ?>"/></div>
            </div>
			
           <?php 
            }
            ?>
        
		</div>
        <div class="pagination1 pagination-style"></div>
        <div class="swiper-btn-style swiper-btn1">
            <div class="swiper-btn-left"></div>
            <div class="swiper-btn-right"></div>
        </div>
    </div>
</div>
<!--优势-->
<?php 
            $menuList = \think\facade\Cache::get("003d582c1aed73fa5cec1c628192e22f");
            $currid   = \think\facade\Cache::get("currid_003d582c1aed73fa5cec1c628192e22f");
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
<div class="index-a margin-t60">
    <div class="w1388">
		<div class="title title1 text-center">
			<h3>为什么选择我们</h3>
			<p>    本公司拥有完整、科学的质量管理体系。我们的诚信、实力和产品质量获得业界的广泛认可。</p>
			<i></i>
		   
		</div>
        <ul class="clear">
     
		   <li>     
				<div class="table">
					<div class="table-cell">
						<div class="index-a-title">
							<h3>98%</h3>
							<p>顾客好评</p>
						</div>
				
					</div>
				</div>
            </li>
			<li>     
				<div class="table">
					<div class="table-cell">
						<div class="index-a-title">
							<h3>500+</h3>
							<p>合作经销商</p>
						</div>
				
					</div>
				</div>
            </li>
			<li>     
				<div class="table">
					<div class="table-cell">
						<div class="index-a-title">
							<h3>9818 <b style="font-size:14px">项</b></h3>
							<p>国家专利</p>
						</div>
				
					</div>
				</div>
            </li>
			<li>     
				<div class="table">
					<div class="table-cell">
						<div class="index-a-title">
							<h3>1500+</h3>
							<p>优质客户群</p>
						</div>
				
					</div>
				</div>
            </li>
			
        </ul>
    </div>
</div>
<?php  unset($pid); 
                         } 
                        unset($field);
                     ?>
<!--产品-->
<?php 
            $menuList = \think\facade\Cache::get("33e52e6a7280b4dba39d5120e7e671b4");
            $currid   = \think\facade\Cache::get("currid_33e52e6a7280b4dba39d5120e7e671b4");
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
<div class="pro f7 margin-t60">
	<div class="w1240">
		<div class="title title1 text-center">
            <h3><?php echo htmlentities($field['typename']); ?></h3>
			<p><?php echo htmlentities($field['description']); ?></p>
            <i></i>
        </div>
		<div class="tab-btn">
		<?php 
           
            if(isset($pid) && empty("0")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                $menuList =\app\common\model\Arctype::where($where)->limit(0,10)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("1aa5a28e21cef8fd018395c76961644d");
            }
            $currid   = \think\facade\Cache::get("currid_1aa5a28e21cef8fd018395c76961644d");
            
            foreach($menuList as $key => $field){
                   $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                   $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
		   $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                   $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
		<a class='active' href="javascript:;"><?php echo htmlentities($field['typename']); ?></a>
		<?php } 
                    unset($field);
                 ?> 			 
		</div>
		<div class="tabs">
		   <div class="tabpage ">
			<ul class="index-pro index-pro clear margin-t50 ">
			<?php $arclist = \think\facade\Cache::get("062bf2cbfbf3c9a486ba80ac9551adbf");
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
                        ->join("yy_addonarticle add"," arc.id=add.aid","left")
                        ->join("arctype m","arc.typeid = m.id","left")    
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.pubdate desc")
                        ->field("arc.*,add.*,m.typename")
                        ->limit(0,4)
                            
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("062bf2cbfbf3c9a486ba80ac9551adbf",$arclist);  
                 } 
            $parentsField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = mb_substr($field["title"],0,120);
                $field["litpic"] = $field["litpic"] ?$field["litpic"] :"__YYADMIN__/images/images.jpg";    
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"]) ? $field["redirecturl"] : \think\facade\Route::buildUrl("view",["aid"=>$field["id"]]);
                $field["typeurl"] =  url("template/list",["tid"=>$field["id"]]);
                ?>
			
			<li class="imgscale">
				<a href="<?php echo htmlentities($field['arcurl']); ?>">
					<?php if(!isMobile() && ($key==0||$key==2)): ?>
					<div class="pro-list-bot relative">
						<b><?php echo htmlentities($field['title']); ?></b>
					    <h5><?php echo htmlentities(mb_substr($field['description'],0,45)); ?>…</h5>
						<div class="border"></div>
					</div>
					<div class="img100"><img src="<?php echo htmlentities($field['litpic']); ?>"/></div>
					<?php else: ?>
					<div class="img100"><img src="<?php echo htmlentities($field['litpic']); ?>"/></div>
					<div class="pro-list-bot relative">
						<b><?php echo htmlentities($field['title']); ?></b>
					    <h5><?php echo htmlentities(mb_substr($field['description'],0,45)); ?>…</h5>
						<div class="border"></div>
					</div>
					
					<?php endif; ?>
				</a>
			</li>
			 <?php }
                   $field = isset($parentsField) ? $parentsField :""; 
                ?>
			 </ul>
			</div>
		 </div>
	</div>
</div>
<?php  unset($pid); 
                         } 
                        unset($field);
                     ?>	

<!--案例-->
 <?php 
            $menuList = \think\facade\Cache::get("36392aa9f6b4732dd0eb75016901d4ec");
            $currid   = \think\facade\Cache::get("currid_36392aa9f6b4732dd0eb75016901d4ec");
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
<div class="margin-t60">
    <div class="w1240">
	      <div class="title1 text-center">
           
			<h3><?php echo htmlentities($field['typename']); ?></h3>
            <i></i>
            <p><?php echo htmlentities($field['description']); ?></p>
			
        </div>
        <div class="tab-btn">
			<?php 
           
            if(isset($pid) && empty("2")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                $menuList =\app\common\model\Arctype::where($where)->limit(0,10)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("93c403bf678acbb3248340ceac3a7b72");
            }
            $currid   = \think\facade\Cache::get("currid_93c403bf678acbb3248340ceac3a7b72");
            
            foreach($menuList as $key => $field){
                   $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                   $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
		   $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                   $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
			<a class='active' href="javascript:;"><?php echo htmlentities($field['typename']); ?></a>
			<?php } 
                    unset($field);
                 ?> 			 
		</div>
        <div class="tabs margin-t50">
        <div class="tabpage active">
                    <ul class="anli-list clear">
                    <?php $arclist = \think\facade\Cache::get("e2b46726085fd243ff6a1a1a7e682ae7");
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
                        ->join("yy_addonarticle add"," arc.id=add.aid","left")
                        ->join("arctype m","arc.typeid = m.id","left")    
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.pubdate desc")
                        ->field("arc.*,add.*,m.typename")
                        ->limit(0,3)
                            
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("e2b46726085fd243ff6a1a1a7e682ae7",$arclist);  
                 } 
            $parentsField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = mb_substr($field["title"],0,120);
                $field["litpic"] = $field["litpic"] ?$field["litpic"] :"__YYADMIN__/images/images.jpg";    
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"]) ? $field["redirecturl"] : \think\facade\Route::buildUrl("view",["aid"=>$field["id"]]);
                $field["typeurl"] =  url("template/list",["tid"=>$field["id"]]);
                ?>
					<li>
                            <a  class="relative" href="<?php echo htmlentities($field['arcurl']); ?>">
                                <div class="img100"><img src="<?php echo htmlentities($field['litpic']); ?>"/></div>
                                <div class="anli-con">
                                   <div class="table">
                                    <div class="table-cell">
                                        <h4><?php echo htmlentities($field['title']); ?></h4>
                                        <i></i>
                                    </div>
                                </div>
                                </div>
                            </a>
                        </li>
						 <?php }
                   $field = isset($parentsField) ? $parentsField :""; 
                ?>
						 </ul>
                </div>
	</div>
    </div>
</div>
<?php  unset($pid); 
                         } 
                        unset($field);
                     ?>	
<!--about-->
 <?php 
            $menuList = \think\facade\Cache::get("003d582c1aed73fa5cec1c628192e22f");
            $currid   = \think\facade\Cache::get("currid_003d582c1aed73fa5cec1c628192e22f");
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
<div class="margin-t60 f7">
	<div class="w1240">
		<div class="title title1 text-center">
            <h3><?php echo htmlentities($field['typename']); ?></h3>
			<p><?php echo htmlentities($field['description']); ?></p>
            <i></i>
            
        </div>
        <div class="about">
			 <div class="about-txt">
				<h1><?php echo htmlentities($field['typename']); ?></h1>
				<h3>About us</h3>
				<p></p>
				<div class="cont"> <?php echo $field['content']; ?>…</div>
			</div>
			
			
        </div>
    </div>
	
</div>
<?php  unset($pid); 
                         } 
                        unset($field);
                     ?>
<!--新闻-->
<?php 
            $menuList = \think\facade\Cache::get("db35bcf1a4c68a7f101341f6b5d01200");
            $currid   = \think\facade\Cache::get("currid_db35bcf1a4c68a7f101341f6b5d01200");
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
<div class="margin-t60">
    <div class="w1240">
	      <div class="title1 text-center">
            <h3><?php echo htmlentities($field['typename']); ?></h3>
            <i></i>
            <p><?php echo htmlentities($field['description']); ?></p>
        </div>
        <ul class="xw-list clear">
        <?php $arclist = \think\facade\Cache::get("7913e2fdc79a53810fc381b977972151");
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
                        ->join("yy_addonarticle add"," arc.id=add.aid","left")
                        ->join("arctype m","arc.typeid = m.id","left")    
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.pubdate desc")
                        ->field("arc.*,add.*,m.typename")
                        ->limit(0,8)
                            
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("7913e2fdc79a53810fc381b977972151",$arclist);  
                 } 
            $parentsField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = mb_substr($field["title"],0,120);
                $field["litpic"] = $field["litpic"] ?$field["litpic"] :"__YYADMIN__/images/images.jpg";    
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"]) ? $field["redirecturl"] : \think\facade\Route::buildUrl("view",["aid"=>$field["id"]]);
                $field["typeurl"] =  url("template/list",["tid"=>$field["id"]]);
                ?>
		<li class="imgscale">
                <a class="relative" href="<?php echo htmlentities($field['arcurl']); ?>">
                    <div class="img100"><img src="<?php echo htmlentities($field['litpic']); ?>"/></div>
                    <div class="xw-con">
                        <div class="table">
                            <div class="table-cell">
                                <div class="xw-txt">
                                    <h4><?php echo htmlentities($field['title']); ?></h4>
                                   
                                    <p><?php echo htmlentities($field['description']); ?>…</p>
									 <span><?php echo htmlentities(date('Y/m/d',!is_numeric($field['pubdate'])? strtotime($field['pubdate']) : $field['pubdate'])); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
			 <?php }
                   $field = isset($parentsField) ? $parentsField :""; 
                ?>
			        </ul>
    </div>
</div>
<?php  unset($pid); 
                         } 
                        unset($field);
                     ?>
<!--合作品牌-->
<div class="margin-t60">
	<div class="cptd-box pc-show" >
	  <div class="container">
		<div class="title title1 text-center">
			<h3>合作伙伴</h3>
			<i></i>
			<p>    本公司拥有完整、科学的质量管理体系。我们的诚信、实力和产品质量获得业界的广泛认可。</p>
		</div>
		<ul class="yunu-pinzhi clear">
			 <?php 
            $where = [];
            $where[] = ["typeid","=",3];
            $MyppModel = new \app\common\model\Myppt();
            $list=$MyppModel->where($where)->select()->toArray();
                    foreach($list as $key => $field){
                        $field["picname"] = $field["pic"];
                        $field["arcurl"]  =$field["url"];
                        ?>
			 <li > <a href="<?php echo htmlentities($field['url']); ?>" class="imgscale"><div class="img-center img100"><img src="<?php echo htmlentities($field['pic']); ?>" alt="" ></div></a> </li>
			
           <?php 
            }
            ?>
        
			<div class="clear"></div>
		</ul>
	  </div>
	</div>
</div>

 <div class="footer">
   
    <div class="footer-mid">
        <div class="w1240 clear">
            
            <div class="fl col">
                <div class="fot-lxwm">
					<h3>CONTACT INFORMATION</h3>
                    <h5>联系我们</h5>
					<div class='line'></div>
                    <p><span class="icon iconfont icon-weizhi "></span>  <?php echo syscfg('cfg_add'); ?></p>
					<p><span class="icon iconfont icon-tel"></span> <?php echo syscfg('cfg_tel'); ?></p>
					<p><span class="icon iconfont icon-email"></span> <?php echo syscfg('cfg_email'); ?></p>
                </div>
            </div>
			<div class="fl col border">
				<div class="fl footer-mid-left">
					<div class="code">
						<h3>CONTACT INFORMATION</h3>
						<h5>公众号</h5>
						<div class='line'></div>
						<p>欢迎关注我们的官方公众号</p>
						<img src="/skin/images/erweima.png" width='140' style="margin-top:15px">
					</div>
				</div>
             </div>
			 <div class="fl col">
                <div class="message">
					<h3>CONTACT INFORMATION</h3>
                    <h5>联系我们</h5>
					<div class='line'></div>
					
                    <div>
						<textarea class="InputText form-control" id="" name="item_30" maxlength="255" placeholder="请输入留言内容" data-required="true" tit="留言内容"></textarea>
					</div>
					 <div>
						<input name="captchas" class="InputText form-control" type="input" data-required="true" value="" placeholder="请输入验证码" maxlength="5" tit=" 验证码" data-error=" 验证码错误或已失效">
					  </div>
					 <div>
						<button type="button" class="btn btn-primary submitPC p_submit" data-ename="提交按钮">提交</button>
					 </div>
                </div>
            </div>
        </div>
    </div>
  <div class="footer-bot">
        <div class="w1388">
            <span class="zt"><?php echo syscfg('cfg_powerby'); ?></span>
            <a target="_blank" href="http://beian.miit.gov.cn" style="color: #8c8c8c;font-family: dincondBold;"><?php echo syscfg('cfg_beian'); ?></a>
        </div>
    </div>
    <div class="fubox">
        <div class="fu-list fu-list-tel clear">
            <div class="fu-warp fr">
                <div class="fu-txt">
                    <p><?php echo syscfg('cfg_tel'); ?></p>
                </div>
            </div>
            <div class="fu-icon fr"><img src="/skin/images/r-tel.png" alt=""/></div>
        </div>
        <div class="fu-list fu-list-qq clear">
            <a class="clear" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo syscfg('cfg_qq'); ?>&site=qq&menu=yes">
                <div class="fu-warp fr">
                    <div class="fu-txt">
                        <p>在线客服</p>
                    </div>
                </div>
                <div class="fu-icon fr"><img src="/skin/images/r-qq.png" alt=""/></div>
            </a>
        </div>
        <div class="fu-list  clear">
            <div class="weixin-code"><img src="/skin/images/code.jpg" alt=""></div>
            <div class="fu-icon fr"><img src="/skin/images/r-wx.png" alt=""/></div>
        </div>
        <div class="fu-list clear">
            <div class="fu-icon fr"><a target="_blank" href="http://www.weibo.com"><img src="/skin/images/r-wb.png" alt=""/></a></div>
        </div>
        <div class="fu-list toTop clear">
            <div class="fu-icon fr"><img src="/skin/images/r-top.png" alt=""/></div>
        </div>
    </div>
</div>
<div class="head-top head-top2 phone-show">
    <div class="w1388">
        <a class="hotLine text-center" href="tel:<?php echo syscfg('cfg_tel'); ?>" style="display: block;">
            <span class="span1">全国咨询热线：</span>
            <span class="span2"><?php echo syscfg('cfg_tel'); ?></span>
        </a>
    </div>
</div>
<script src="/skin/js/wow.min.js"></script>
</body>
<script>
    var banner = new Swiper('.banner .swiper-container', {
        autoplay: 6000,//可选选项，自动滑动
        speed:600,
        loop:true,
        autoplayDisableOnInteraction : false,
        pagination : '.pagination1',
        paginationClickable :true,
        prevButton:'.swiper-btn1 .swiper-btn-left',
        nextButton:'.swiper-btn1 .swiper-btn-right'
    });
    $('.ppgs-l').click(function(){
        $(this).find('.img100').hide();
        $(this).find('video')[0].play();
    });
    $('.kp-big-bot').click(function(){
        $(this).parent().addClass('active').find('video')[0].play();
    });
    $('.tab-btn a').click(function(){
        var index=$(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $(this).parent().siblings('.tabs').find('.tabpage').eq(index).addClass('active').siblings().removeClass('active');
    });
</script>
</html>