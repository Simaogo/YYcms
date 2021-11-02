<?php /*a:4:{s:29:"../template/default/index.htm";i:1635526718;s:5:"param";i:0;s:28:"../template/default/head.htm";i:1635526717;s:30:"../template/default/footer.htm";i:1635526717;}*/ ?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo syscfg('cfg_webname'); ?></title>
  <meta name="description" content="<?php echo syscfg('cfg_description'); ?>" />
  <meta name="keywords" content="<?php echo syscfg('cfg_keywords'); ?>" />
  <meta http-equiv="mobile-agent" content="format=xhtml;url=/m/index.php">
  <script type="text/javascript">
    if (window.location.toString().indexOf('pref=padindex') != -1) {} else {
      if (/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (
          /MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/
          .test(navigator.userAgent))) {
        if (window.location.href.indexOf("?mobile") < 0) {
          try {
            if (/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
              window.location.href = "/m/index.php";
            } else if (/iPad/i.test(navigator.userAgent)) {} else {}
          } catch (e) {}
        }
      }
    }
  </script>
  <link charset="gb2312" href="/skin/css/indexcss.css" rel="stylesheet" type="text/css" />
  <script language="JavaScript" type="text/javascript" src="/skin/js/indexjs.js"></script>
  </head>
  <body>
<link charset="gb2312" href="/skin/css/allbag.css" rel="stylesheet" type="text/css" />
<!--head--> 
<div id="head_box">
  <div id="head">
    <div id="head_left"><?php echo syscfg('cfg_gg'); ?></div>
    <div id="head_right"><a href="/">返回首页</a> | <?php $field = \think\facade\Cache::get("typeinfo_2");$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);$field["typeurl"] = \think\facade\Config::get("app.list_url") ."/tid/". $field["id"]; ?><a
        href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a> | <?php $field = \think\facade\Cache::get("typeinfo_14");$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);$field["typeurl"] = \think\facade\Config::get("app.list_url") ."/tid/". $field["id"]; ?><a
        href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a> | <?php $field = \think\facade\Cache::get("typeinfo_11");$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);$field["typeurl"] = \think\facade\Config::get("app.list_url") ."/tid/". $field["id"]; ?><a
        href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a><?php ?></div>
  </div>
</div>
<!--top-->
<div id="top">
  <div id="top_logo"><a href="/"><img src="/skin/images/logo.jpg" alt="<?php echo syscfg('cfg_webname'); ?>"></a> </div>
  <div id="top_name">
    <div id="top_name1">德州宏瑞土工材料有限公司</div>
    <div id="top_name2">Dezhou Hongrui geotechnical materials Co., Ltd</div>
  </div>
  <!--<div id="top_img"></div>
  <div id="top_gg">
    <div id="top_gg1"><span>土工膜</span> 土工布</div>
    <div id="top_gg1"><span>复合土工膜</span> 膨润土防水毯</div>
  </div>-->
  <div id="tel"> <span>客户统一服务热线</span>
    <p><?php echo syscfg('cfg_tel'); ?><br>
    </p>
  </div>
</div>
<!--导航 nav--> 
<script src="/skin/js/2.2.4jquery.js"></script>
<div id="nav">
  <div class="nav_o"></div>
  <div id="navW">
    <ul>
      <input type="hidden" value="<?php echo htmlentities($field['id']); ?>" id="tid" />
      <li id="t0"><strong></strong><a href="/">网站首页</a><span></span></li>
      <div class="nav_line"></div>
      <?php 
           
            if(isset($pid) && empty("0")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                
                $menuList =\app\common\model\Arctype::where($where)->limit(0,8)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("c7cbecf2f36497690a30fc4bb4f5fba7");
            }
            $currid   = \think\facade\Cache::get("currid_c7cbecf2f36497690a30fc4bb4f5fba7");
            
            foreach($menuList as $key => $field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
					$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
					$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"active":"";//栏目显示高亮
            ?>
      <li id="t<?php echo htmlentities($field['id']); ?>"><strong></strong><a
          href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a><span></span></li>
      <?php } 
                 ?>
    </ul>
  </div>
  <div class="nav_u"></div>
</div>
<script>
    $(function(){
        var tid=$("#tid").val();
        if(tid==""){
            $("#t0").addClass("a_nav");
        }else{
            $("#t"+tid).addClass("a_nav");
        }
    })
</script><script type="text/javascript">
  // JavaScript Document
  var curUrl = location.pathname.substr(1);
  if (curUrl.indexOf("company") > -1) {
    document.getElementById('aa1').className = " a_nav";
  };
  if (curUrl.indexOf("products") > -1) {
    document.getElementById('aa2').className = " a_nav";
  };
  if (curUrl.indexOf("132964") > -1) {
    document.getElementById('aa3').className = " a_nav";
  };
  if (curUrl.indexOf("146470") > -1) {
    document.getElementById('aa4').className = " a_nav";
  };
  if (curUrl.indexOf("132981") > -1) {
    document.getElementById('aa5').className = " a_nav";
  };
  if (curUrl.indexOf("132983") > -1) {
    document.getElementById('aa6').className = " a_nav";
  };
  if (curUrl.indexOf("feedback") > -1) {
    document.getElementById('aa7').className = " a_nav";
  };
  if (curUrl.indexOf("132982") > -1) {
    document.getElementById('aa8').className = " a_nav";
  };
</script> 
<!--banner-->
<link href="/skin/css/css.css" rel="stylesheet">
<script src="/skin/js/min.js" type="text/javascript"></script> 
<script src="/skin/js/banner1.js"></script>
<div id="banner" class="owl-carousel owl-theme"> <?php 
            $where = [];
            $where[] = ["typeid","=",2];
            $MyppModel = new \app\common\model\Myppt();
            $list=$MyppModel->where($where)->select()->toArray();
                    foreach($list as $key => $field){
                        $field["picname"] = $field["pic"];
                        $field["arcurl"]  =$field["url"];
                        ?>
    <div class="item"> <a href="<?php echo htmlentities($field['url']); ?>">
      <div style="background:url(<?php echo htmlentities($field['picname']); ?>)no-repeat center; height:563px; "></div>
      </a> </div>
    
           <?php 
            }
            ?>
         </div>
<div class="cl"></div>
<script type="text/javascript">
  $(document).ready(function () {
    $("#banner").owlCarousel({
      navigation: true,
      singleItem: true,
      autoPlay: 5000,
      transitionStyle: "fadeUp"
    });
  });
</script> 
<!-- end--> 
<!--search-->
<div class="search_bg">
    <div class="search">
    <div class="search_l">
        <div class="search_l_txt"> <span>一直专注土工合成材料领域</span><br>
        厂家直销，免费邮递样品 </div>
      </div>
    <div class="search_cen">
        <form action="<?php echo url('template/search'); ?>" target="_blank">
        <div class="search_cen_txt">
            <div id="search-bg">
            <input type="search" name="q" id="infoname"
                style=" height:26px; line-height:29px; padding-left:8px; border:none; outline: none"
                placeholder="请输入关键字" size="25">
          </div>
            <input type="hidden" name="pagesize" value="5" />
            <div id="search-i">
            <button type="submit" style="background: url(/skin/images/search.jpg) no-repeat;
              height: 100%; width: 100%; border: 0;"></button>
          </div>
          </div>
        <div id="search-text">热门搜索： {dede:hotwords  num=6  subday=365 maxlength=20/} </div>
        <script>
            document.onreadystatechange = loadFromCookie;

            function loadFromCookie() {
              if (document.readyState == "complete") {
                var reg = /key_word=([^;]+)/img;
                var mc = reg.exec(document.cookie);
                if (mc && mc.length >= 1) document.getElementById("infoname").value = decodeURIComponent(mc[1]);
              }
            }
          </script>
      </form>
      </div>
    <div class="search_r">
        <div class="search_r_img"><img src="/skin/images/shili.png" alt="<?php echo syscfg('cfg_webname'); ?>"></div>
        <div class="search_r_txt">生产厂家<br>
        品质保证 </div>
      </div>
  </div>
  </div>
<div class="search_bo"></div>
 <!--产品--> 
<?php 
            $menuList = \think\facade\Cache::get("71c4557892051e19176d63dcf941d5e9");
            $currid   = \think\facade\Cache::get("currid_71c4557892051e19176d63dcf941d5e9");
            $selftypeid = 2;  
            foreach($menuList as $key => $field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
					$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
					$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮 
                    $pid = $field["id"];//嵌套标签typeid传值    
            ?>
<div id="products_box">
    <div id="top60"></div>
    <div id="top20"></div>
    <div id="agent_bt1" data-scroll-reveal="enter bottom and move 50px over 0.5s"><?php echo htmlentities($field['typename']); ?></div>
    <div id="agent_bt2"><?php echo htmlentities($field['description']); ?></div>
    <div id="agent_btline">
    <div id="agent_btlinel"></div>
    <div id="agent_btliner"></div>
  </div>
    <div id="top30"></div>
    <div id="products_dh">
    <ul>
        <?php 
           
            if(isset($pid) && empty("0")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                
                $menuList =\app\common\model\Arctype::where($where)->limit(0,12)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("ba1080927762209ba813d921bbd11e3a");
            }
            $currid   = \think\facade\Cache::get("currid_ba1080927762209ba813d921bbd11e3a");
            
            foreach($menuList as $key => $field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
					$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
					$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
        <div id="showtd0" onMouseOver="javascript:div_show(0);" class="on">
        <li><a href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a><span></span></li>
      </div>
        <?php } 
                 ?>
      </ul>
  </div>
    <div id="products_bg">
    <div id="showdiv0">
        <div class="produ_cont_page pro_cont2" id="prod_showdiv0">
        <table width=100% border=0 align=center cellpadding=0 cellspacing=0>
            <?php $arclist = \think\facade\Cache::get("37d62da18def0aca1e980342944185be");
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
                        ->order("arc.sortrank asc")
                        ->limit(0,12)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("37d62da18def0aca1e980342944185be",$arclist);  
                 } 
            $paranField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = substr($field["title"],0,100);
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"])?$field["redirecturl"] : \think\facade\Config::get("app.view_url")."/aid/".$field["id"];
            ?>
            
            <td align=center style=padding-left:5px><a href="<?php echo htmlentities($field['arcurl']); ?>" target='_blank'> <img src="<?php echo htmlentities($field['litpic']); ?>" width="251" height="200" alt='<?php echo htmlentities($field['title']); ?>'
                  title='<?php echo htmlentities($field['title']); ?>' border=0> </a><br>
                <span style="line-height:25px;"> <a href="<?php echo htmlentities($field['arcurl']); ?>" target='_blank' title="<?php echo htmlentities($field['title']); ?>"> <?php echo htmlentities($field['title']); ?> </a> </span></td>
             <?php }  
                   $field = isset($paranField) ? $paranField :""; 
                ?> </tr>
          </table>
      </div>
      </div>
    <script language="JavaScript" type="text/javascript">
        var $$ = function (prod_totid) {
          return document.getElementById(prod_totid);
        }

        function prod_div_show(prod_total) {
          for (prod_tot_i = 0; prod_tot_i <= 4; prod_tot_i++) {
            if (prod_tot_i == prod_total) {
              $$('prod_showdiv' + prod_tot_i).style.display = "Block";
            } else {
              $$('prod_showdiv' + prod_tot_i).style.display = "None";
            }
          }
        }
      </script> 
  </div>
  </div>
<?php  unset($pid); };
        ?>
<!--agent-->
<!--<div id="agent_box">
    <div id="top20"></div>
    {yycms:type typeid='26'}
    <div id="agent_bt1" data-scroll-reveal="enter bottom and move 50px over 0.5s"><?php echo htmlentities($field['typename']); ?></div>
    <div id="agent_bt2"><?php echo htmlentities($field['description']); ?></div>
    {/yycms:type}
    <div id="agent_btline">
    <div id="agent_btlinel"></div>
    <div id="agent_btliner"></div>
  </div>
    <div id="agent">
    <ul>
        <?php $arclist = \think\facade\Cache::get("d6f227cdaf54747192a04e2dddae2f86");
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
                        ->order("arc.sortrank asc")
                        ->limit(0,4)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("d6f227cdaf54747192a04e2dddae2f86",$arclist);  
                 } 
            $paranField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = substr($field["title"],0,100);
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"])?$field["redirecturl"] : \think\facade\Config::get("app.view_url")."/aid/".$field["id"];
            ?>
        <li><img src="<?php echo htmlentities($field['litpic']); ?>" alt="<?php echo htmlentities($field['title']); ?>" />
        <div class="bt"><?php echo htmlentities($field['title']); ?></div>
        <div class="fl"> <?php echo htmlentities($field['description']); ?> </div>
        <div class="jg"></div>
      </li>
         <?php }  
                   $field = isset($paranField) ? $paranField :""; 
                ?>
      </ul>
  </div>
  </div>-->

<!--工程案例--> 
<?php 
            $menuList = \think\facade\Cache::get("f367f007c9b92bb77d995bda8c9afe37");
            $currid   = \think\facade\Cache::get("currid_f367f007c9b92bb77d995bda8c9afe37");
            $selftypeid = 8;  
            foreach($menuList as $key => $field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
					$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
					$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮 
                    $pid = $field["id"];//嵌套标签typeid传值    
            ?>
<div id="case_box">
    <div id="top50"></div>
    <div id="top30"></div>
    <div id="top50"></div>
    <div class="productsys_bt"><span><a href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a></span></div>
    <div class="productsys_bt1">生成厂家直销<span>免费邮递样品</span></div>
    <div class="productsys_bt2">Provide customers with all-round solutions</div>
    <div id="top30"></div>
    <div id="prod_box">
    <div class="list" data-scroll-reveal="enter left and move 50px over 0.5s">
        <div class="list_t"><?php echo htmlentities($field['typename']); ?><br />
        <span><?php echo htmlentities($field['typenameen']); ?></span></div>
        <div class="list_kb"></div>
        <div class="list_bg">
        <table width='219' border='0' cellspacing='0' cellpadding='0'>
            <?php 
           
            if(isset($pid) && empty("0")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                
                $menuList =\app\common\model\Arctype::where($where)->limit(0,7)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("9bfbd30c4b41acfd28a4774e6a308b21");
            }
            $currid   = \think\facade\Cache::get("currid_9bfbd30c4b41acfd28a4774e6a308b21");
            
            foreach($menuList as $key => $field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
					$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
					$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
            <tr>
            <td style='height:56px;'><a href='<?php echo htmlentities($field['typeurl']); ?>' title='<?php echo htmlentities($field['typename']); ?>' style='line-height:56px;color:#fff;'> <?php echo htmlentities($field['typename']); ?> </a></td>
          </tr>
            <?php } 
                 ?>
          </table>
      </div>
        <div class="list_kbx"></div>
      </div>
    <div class="pr_nr" data-scroll-reveal="enter right and move 50px over 0.5s">
        <div class="pr_dh">
        <ul>
            <?php 
           
            if(isset($pid) && empty("0")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                
                $menuList =\app\common\model\Arctype::where($where)->limit(0,5)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("d40d610682937bb4ff3e2375f9000d71");
            }
            $currid   = \think\facade\Cache::get("currid_d40d610682937bb4ff3e2375f9000d71");
            
            foreach($menuList as $key => $field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
					$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
					$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
            <div id="showtd0" onMouseOver="javascript:div_show(0);" class="on">
            <li><a href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a><span></span></li>
          </div>
            <?php } 
                 ?>
          </ul>
      </div>
        <div id="showdiv0">
        <div class="use_d">
            <table width=100% border=0 align=center cellpadding=0 cellspacing=0>
            <?php $arclist = \think\facade\Cache::get("9055d44ce017636672553e745d1dd556");
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
                        ->order("arc.sortrank asc")
                        ->limit(0,6)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("9055d44ce017636672553e745d1dd556",$arclist);  
                 } 
            $paranField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = substr($field["title"],0,100);
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"])?$field["redirecturl"] : \think\facade\Config::get("app.view_url")."/aid/".$field["id"];
            ?>
            
                <td align=center style=padding-left:5px;><a href=<?php echo htmlentities($field['arcurl']); ?>> <img src="<?php echo htmlentities($field['litpic']); ?>" width="257" height="193" border=0 alt="<?php echo htmlentities($field['title']); ?>"> </a> <br>
                <div style=padding-top:5px;> <a href=<?php echo htmlentities($field['arcurl']); ?> title="<?php echo htmlentities($field['title']); ?>"> <?php echo htmlentities($field['title']); ?> </a> </div></td>
                 <?php }  
                   $field = isset($paranField) ? $paranField :""; 
                ?>
            </table>
          </div>
      </div>
      </div>
    <script language="JavaScript" type="text/javascript">
        var $$ = function (id) {
          return document.getElementById(id);
        }

        function div_show(total) {
          for (i = 0; i <= 13; i++) {
            if (i == total) {
              $$('showdiv' + i).style.display = "Block";
              $$('showtd' + i).className = 'on';
            } else {
              $$('showdiv' + i).style.display = "None";
              $$('showtd' + i).className = 'out';
            }
          }
        }
      </script> 
    <script type="text/javascript">
        $(".use_d > table > tbody > tr > td ").each(function () {
          proatext = $(this).find('div').find('a').html();
          proaurl = $(this).find('div').find('a').attr('href');
          $(this).append("<div class='ceshigo'>" + "<a>" + proatext +
            "<span class='ceshigo_ai'><span class='ceshigo_ai_l'></span><span class='ceshigo_ai_r'></span></span>" +
            "</a>" + "</div>");
          $(this).find('.ceshigo').find('a').attr('href', proaurl)

        });
      </script> 
  </div>
  </div>
<?php  unset($pid); };
        ?> <!--adv-->
<div id="adv_box">
<div id="top60"></div>
<div class="adv_en">Our advantages</div>
<div class="adv_m">选择我们的<span>四大优势</span></div>
<div class="adv_line"></div>
<div class="adv_s">主营产品：土工膜，土工布，复合土工膜，防水毯，排水板，排水网等土工合成材料</div>
<div id="top50"></div>
<div id="top20"></div>
<div class="advantage">
    <div class="content">
    <div class="advantage1">
        <dl>
        <dt><img src="/skin/images/youshi1.jpg" alt="10多年行业精研" /></dt>
        <dd>
            <h3>公司实力雄厚<b style="padding-top:6px;">产品规格齐全</b></h3>
            <ul>
            <li> ◆主要产品包括土工布,HDPE膜、复合土工膜、排水网、短丝土工布等。</li>
            <li> ◆所有产品均符合行业生产标准。</li>
            <li> ◆专注于水利、环境及生态修复技术研发及产品制造。</li>
            <li> ◆已完成水利工程100多项，环境工程200多项</li>
          </ul>
          </dd>
      </dl>
      </div>
  </div>
    <div class="content">
    <div class="advantage2">
        <dl>
        <dt><img src="/skin/images/youshi2.jpg" alt="应用范围广泛" /></dt>
        <dd>
            <h3>应用范围广泛<b style="padding-top:6px;">深受客户认可</b></h3>
            <ul>
            <li> ◆典型工程包括南水北调工程、三峡工程、滹沱河防渗工程，保定环城水系工程。</li>
            <li> ◆济南垃圾填埋场工程，桂林垃圾填埋场工程、大同电厂防渗工程。</li>
            <li> ◆嘉兴火车站防渗工程、黑龙江农垦防渗工程等</li>
            <li> ◆并有专业的施工工程技术服务团队</li>
          </ul>
          </dd>
      </dl>
      </div>
  </div>
    <div class="content">
    <div class="advantage3">
        <dl>
        <dt><img src="/skin/images/youshi3.jpg" alt="专业土工材料施工技术团队" /></dt>
        <dd>
            <h3>多年深耕土工材料领域<b style="padding-top:6px;">售后无忧</b></h3>
            <ul>
            <li>◆与国内外知名的科研院所及环保企业建立了长期合作关系。</li>
            <li>◆拥有高素质的专业从事水利、环保及生态，</li>
            <li>◆修复方面技术研发、生产制造以及工程服务团队。</li>
            <li>◆热情的售后服务，让您用得安心、省心和开心。</li>
          </ul>
          </dd>
      </dl>
      </div>
  </div>
    <div class="content">
    <div class="advantage4">
        <dl>
        <dt><img src="/skin/images/youshi4.jpg" alt="完善的售后服务" /></dt>
        <dd>
            <h3>完善的售后服务<b style="padding-top:6px;">值得依赖</b></h3>
            <ul>
            <li>◆本公司产品广泛应用于各行各业，被许多客户的认可。</li>
            <li>◆公司倡导“以人为本，诚信经营，以质量求发展”的经营理念。</li>
            <li>◆定期定时对用户回访，随时提供技术指导。</li>
            <li>◆秉承“科技创新，产业报国，服务利民的企业宗旨。</li>
          </ul>
          </dd>
      </dl>
      </div>
  </div>
  </div>
<div id="top60"></div>
<div id="gg_box">
    <div id="gg">
    <div id="gg_l">
        <!--<div id="gg_lt"><span>多年专业经验</span><br />
        集土工合成材料 生产、销售和施工服务</div>
        <div id="gg_ltg">厂家直销 免费邮递样品</div>-->
        <div id="gg_ltel">
        <div id="gg_ltela">服务热线：<?php echo syscfg('cfg_tel'); ?></div>
        <!--<div id="gg_ltelb"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo syscfg('cfg_qq'); ?>&site=qq&menu=yes">立即咨询</a></div>-->
      </div>
      </div>
  </div>
  </div>
<!--公司简介--> 
<?php 
            $menuList = \think\facade\Cache::get("404f724f43946f31892f5968f8426f11");
            $currid   = \think\facade\Cache::get("currid_404f724f43946f31892f5968f8426f11");
            $selftypeid = 1;  
            foreach($menuList as $key => $field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
					$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
					$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮 
                    $pid = $field["id"];//嵌套标签typeid传值    
            ?>
<div class="company_box">
    <div id="top30"></div>
    <div id="top50"></div>
    <div class="productsys_btc"><span><a href=""><?php echo htmlentities($field['typename']); ?></a></span></div>
    <div class="productsys_bt1"><?php echo htmlentities($field['description']); ?><span></span></div>
    <div class="productsys_bt2"><?php echo htmlentities($field['seotitle']); ?></div>
    <div id="top50"></div>
    <div id="company">
    <div class="video"><img src="<?php echo htmlentities($field['typeimg']); ?>" alt="" /></div>
    <div class="company_r">
        <div class="company_rbt"><?php echo htmlentities($field['typename']); ?><span><?php echo htmlentities($field['typenameen']); ?></span></div>
        <div class="company_rbg"> 　　 <?php 
           
            if(isset($pid) && empty("0")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                
                $menuList =\app\common\model\Arctype::where($where)->limit(0,10)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("94227b7bb5fd34d3e6caa1494c247cb4");
            }
            $currid   = \think\facade\Cache::get("currid_94227b7bb5fd34d3e6caa1494c247cb4");
            
            foreach($menuList as $key => $field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
					$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
					$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?> 
        <?php echo $field['content']; } 
                 ?>...... </div>
        <div class="company_rmore"><a href="<?php echo htmlentities($field['typeurl']); ?>">查看更多>></a></div>
      </div>
  </div>
    <div id="top40"></div>
  </div>
<?php  unset($pid); };
        ?> 
<!--news-->
<div class="news">
<div id="top50"></div>
<?php $field = \think\facade\Cache::get("typeinfo_7");$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);$field["typeurl"] = \think\facade\Config::get("app.list_url") ."/tid/". $field["id"]; ?>
<div class="productsys_btd"><span><a href="/xinwen/"><?php echo htmlentities($field['typename']); ?></a></span></div>
<div class="productsys_bt1">综合发布土工布-土工膜相关动态施工技术类文章<span></span></div>
<div class="productsys_bt2">Geotextile-geomembrane correlation dynamics</div>
<?php ?>
<div id="top20"></div>
<div class="lanrenzhijia">
    <div class="tab">
    <div class="news_a"> <?php 
           
            if(isset($pid) && empty("7")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                
                $menuList =\app\common\model\Arctype::where($where)->limit(0,10)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("c2d40c53eeef8bc7febe944bb135dc01");
            }
            $currid   = \think\facade\Cache::get("currid_c2d40c53eeef8bc7febe944bb135dc01");
            
            foreach($menuList as $key => $field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
					$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
					$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?> <a href="<?php echo htmlentities($field['typeurl']); ?>"[field:global name=autoindex runphp="yes"]if(@me==0)@me=" class='on'";else @me="";[/field:global]><?php echo htmlentities($field['typename']); ?></a> <?php } 
                 ?> </div>
  </div>
    <div class="content">
    <ul class="ul">
        <li class="li">
        <div class="news_div"> <?php $arclist = \think\facade\Cache::get("5a0e22b43d6213c2ac7d53b509b78868");
                if(!$arclist){
                    $where=[];
                    $where[]=["arc.arcrank","=",0];
                    if(isset($pid)){
                        $typeid = $pid;
                    }
                    if(isset($selftypeid) && !empty("7")){
                        $typeid = $selftypeid != 0  ? $selftypeid:"7";
                    }
                    if(!empty("7")){
                        $typeid = "7";
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
                        ->order("arc.sortrank asc")
                        ->limit(0,4)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("5a0e22b43d6213c2ac7d53b509b78868",$arclist);  
                 } 
            $paranField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = substr($field["title"],0,76);
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"])?$field["redirecturl"] : \think\facade\Config::get("app.view_url")."/aid/".$field["id"];
            ?>
            <div class="news_div_item">
            <div class="news_div_item_date">
                <div class="news_div_item_year"><?php echo htmlentities($field['pubdate']); ?></div>
                <div class="news_div_item_month"><?php echo htmlentities($field['pubdate']); ?></div>
                <div class="news_div_item_day"><?php echo htmlentities($field['pubdate']); ?></div>
              </div>
            <div class="news_div_item_content">
                <div class="news_div_item_title"><a class="news_div_item_a" href="<?php echo htmlentities($field['arcurl']); ?>"
                        title="<?php echo htmlentities($field['title']); ?>"><?php echo htmlentities($field['title']); ?></a></div>
                <div class="news_div_item_body">　　<?php echo htmlentities($field['description']); ?> </div>
              </div>
            <div class="news_div_item_pic"> <a href="<?php echo htmlentities($field['arcurl']); ?>" title="<?php echo htmlentities($field['title']); ?>"> <img src="<?php echo htmlentities($field['litpic']); ?>" class="news_div_item_image"
                        title="<?php echo htmlentities($field['title']); ?>" alt="<?php echo htmlentities($field['title']); ?>"> </a> </div>
          </div>
             <?php }  
                   $field = isset($paranField) ? $paranField :""; 
                ?> </div>
      </li>
        <?php 
            $menuList = \think\facade\Cache::get("594a841d9203851543076d9b93330889");
            $currid   = \think\facade\Cache::get("currid_594a841d9203851543076d9b93330889");
            $selftypeid = 0;  
            foreach($menuList as $key => $field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
					$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
					$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮 
                    $pid = $field["id"];//嵌套标签typeid传值    
            ?>
        <li class="li">
        <div class='divdgweb_new_div'> <?php $arclist = \think\facade\Cache::get("e451169f77c7db5e12b8bd14c2caba63");
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
                        ->order("arc.sortrank asc")
                        ->limit(0,4)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("e451169f77c7db5e12b8bd14c2caba63",$arclist);  
                 } 
            $paranField = isset($field) ? $field :"";
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = substr($field["title"],0,76);
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"])?$field["redirecturl"] : \think\facade\Config::get("app.view_url")."/aid/".$field["id"];
            ?>
            <div class="news_div_item">
            <div class="news_div_item_date">
                <div class="news_div_item_year"><?php echo htmlentities($field['pubdate']); ?></div>
                <div class="news_div_item_month"><?php echo htmlentities($field['pubdate']); ?></div>
                <div class="news_div_item_day"><?php echo htmlentities($field['pubdate']); ?></div>
              </div>
            <div class="news_div_item_content">
                <div class="news_div_item_title"><a class="news_div_item_a" href="<?php echo htmlentities($field['arcurl']); ?>"
                          title="<?php echo htmlentities($field['title']); ?>"><?php echo htmlentities($field['title']); ?></a></div>
                <div class="news_div_item_body">　　<?php echo htmlentities($field['description']); ?> </div>
              </div>
            <div class="news_div_item_pic"> <a href="<?php echo htmlentities($field['arcurl']); ?>" title="<?php echo htmlentities($field['title']); ?>"> <img src="<?php echo htmlentities($field['litpic']); ?>" class="news_div_item_image"
                          title="<?php echo htmlentities($field['title']); ?>" alt="<?php echo htmlentities($field['title']); ?>"> </a> </div>
          </div>
             <?php }  
                   $field = isset($paranField) ? $paranField :""; 
                ?> </div>
      </li>
        <?php  unset($pid); };
        ?>
      </ul>
  </div>
  </div>
<script>
        $(function () {
          $('.lanrenzhijia .content .ul').width(1200 * $('.lanrenzhijia .content li').length + 'px');
          $(".lanrenzhijia .tab a").mouseover(function () {
            $(this).addClass('on').siblings().removeClass('on');
            var index = $(this).index();
            number = index;
            var distance = -1200 * index;
            $('.lanrenzhijia .content .ul').stop().animate({
              left: distance
            });
          });

          var auto = 0; //等于1则自动切换，其他任意数字则不自动切换
          if (auto == 1) {
            var number = 0;
            var maxNumber = $('.lanrenzhijia .tab a').length;

            function autotab() {
              number++;
              number == maxNumber ? number = 0 : number;
              $('.lanrenzhijia .tab a:eq(' + number + ')').addClass('on').siblings().removeClass('on');
              var distance = -1200 * number;
              $('.lanrenzhijia .content .ul').stop().animate({
                left: distance
              });
            }
            var tabChange = setInterval(autotab, 3000);
            //鼠标悬停暂停切换
            $('.lanrenzhijia').mouseover(function () {
              clearInterval(tabChange);
            });
            $('.lanrenzhijia').mouseout(function () {
              tabChange = setInterval(autotab, 3000);
            });
          }
        });
      </script>
<div id="top30"></div>

<!--end-->
<div class="links">
    <div class="linksW">
    <div class="links_l">
        <div class="links_lm">友情链接</div>
        <div class="links_len">links</div>
      </div>
    <div class="links_r">
        <style type='text/css'>
              .linkTagcs {
                width: 1065px;
                height: auto;
              }

              .linkTagcs ul {
                margin: 0px;
                padding: 0px;
                list-style-type: none;
              }

              .linkTagcs li {
                list-style: none;
                margin: 0px;
                padding-right: 10px;
                line-height: 24px;
                float: left;
              }

              .linkTagcs li a {
                color: #fff;
                word-break: break-all;
              }

              .linkTagcs li img {
                border: 0px;
              }
            </style>
        <?php $flink = \think\facade\Cache::get("flink");
                if (!$flink){
                    $flink = \app\common\model\Flink::limit(0,10)->order("sortrank desc")->select();
                    \think\facade\Cache::set("flink", $flink, 3600);
                }
                foreach($flink as $key=>$field){ 
                ?><a href="<?php echo htmlentities($field['url']); ?>" target="_blank"><?php echo htmlentities($field['webname']); ?></a> <?php } ?> </div>
  </div>
  </div>
<div class="footer_d">
  <div class="footer_dW">
    <div class="footer_d_l">
      <div class="footer_d_m">公司简介</div>
      <div class="footer_d_line"></div>
      <div class="footer_d_ld">
        <table width="96%" border="0" cellpadding="0" cellspacing="0">
          <tbody>
          
          <?php 
            $menuList = \think\facade\Cache::get("1e3809ab47ce9ed38c773fd619abaabb");
            $currid   = \think\facade\Cache::get("currid_1e3809ab47ce9ed38c773fd619abaabb");
            $selftypeid = 0;  
            foreach($menuList as $key => $field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
					$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
					$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮 
                    $pid = $field["id"];//嵌套标签typeid传值    
            ?>
          <tr>
            <td height="30"><a href="<?php echo htmlentities($field['typeurl']); ?>" style="color:#0;;font-weight:1"
										title="<?php echo htmlentities($field['typename']); ?>"><?php echo htmlentities($field['typename']); ?> </a></td>
          </tr>
          <?php  unset($pid); };
        ?>
          </tbody>
          
        </table>
      </div>
    </div>
    <?php 
            $menuList = \think\facade\Cache::get("e56489a0220bd67e1f65b69eaeb27772");
            $currid   = \think\facade\Cache::get("currid_e56489a0220bd67e1f65b69eaeb27772");
            $selftypeid = 0;  
            foreach($menuList as $key => $field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
					$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
					$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮 
                    $pid = $field["id"];//嵌套标签typeid传值    
            ?>
    <div class="footer_d_l">
      <div class="footer_d_m"><?php echo htmlentities($field['typename']); ?></div>
      <div class="footer_d_line"></div>
      <div class="footer_d_ld">
        <div class="footer_d_ld_a">
          <table width="200" border="0" cellspacing="0" cellpadding="0">
            <tbody>
            
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
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
					$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
					$field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
            <tr>
              <td style="height:30px;"><a href="<?php echo htmlentities($field['typeurl']); ?>" title="<?php echo htmlentities($field['typename']); ?>"
										style="line-height:30px;color:#999;"> <?php echo htmlentities($field['typename']); ?> </a></td>
            </tr>
            <?php } 
                 ?>
            </tbody>
            
          </table>
        </div>
      </div>
    </div>
    <?php  unset($pid); };
        ?>
    <div class="footer_d_i">
      <div class="footer_d_m">联系我们</div>
      <div class="footer_d_line"></div>
      <div class="footer_d_id"> 电　话：<?php echo syscfg('cfg_tel'); ?><br>
        手　机：<?php echo syscfg('cfg_phone'); ?><br>
        联系人：<?php echo syscfg('cfg_lxr'); ?><br>
      地址：<?php echo syscfg('cfg_add'); ?><br>
        网　址：<a href="">www.dzhrxcl.cn</a> </div>
    </div>
    <div class="footer_d_r">
      <div class="footer_d_m">网站二维码</div>
      <div class="footer_d_line"></div>
      <div class="footer_d_rd">
        <div class="footer_d_rd_l"><img src="/skin/images/weixin.jpg"/> 手机网站</div>
        <div class="footer_d_rd_l footer_d_rd_r"><img src="/skin/images/weixin.jpg"/>微信</div>
      </div>
    </div>
  </div>
</div>
<div class="copy">
  <div class="copyW"> <?php echo syscfg('cfg_powerby'); ?>  ICP备案：<a href="https://beian.miit.gov.cn/#/Integrated/recordQuery" target="_blank"
			rel="nofollow"><?php echo syscfg('cfg_beian'); ?></a> </div>
</div>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?578ff8d331d7406c29094003df7fd4cf";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>