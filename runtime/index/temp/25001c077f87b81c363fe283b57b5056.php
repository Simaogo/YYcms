<?php /*a:5:{s:37:"../template/default/index_article.htm";i:1635526718;s:5:"param";s:24:"a:1:{s:3:"tid";s:1:"1";}";s:28:"../template/default/head.htm";i:1635526717;s:26:"../template/default/so.htm";i:1635526720;s:30:"../template/default/footer.htm";i:1635526717;}*/ ?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo htmlentities($yy['field']['title']); ?>_<?php echo syscfg('cfg_webname'); ?></title>
<meta name="keywords" content="<?php echo htmlentities($yy['field']['keywords']); ?>" />
<meta name="description" content="<?php echo htmlentities($yy['field']['description']); ?>" />
  <meta http-equiv="mobile-agent" content="format=xhtml;url=/m/list.php?tid=1">
  <script type="text/javascript">if(window.location.toString().indexOf('pref=padindex') != -1){}else{if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){if(window.location.href.indexOf("?mobile")<0){try{if(/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){window.location.href="/m/list.php?tid=1";}else if(/iPad/i.test(navigator.userAgent)){}else{}}catch(e){}}}}</script>
  <link charset="utf-8" href="/skin/css/indexcss.css" rel="stylesheet" type="text/css" />
  <script language="JavaScript" type="text/javascript" src="/skin/js/indexjs.js"></script>
  <link href="/skin/css/headcss.css" rel="stylesheet" type="text/css" />
</head>
<body onload="themax();init();">
  <link charset="gb2312" href="/skin/css/headcss.css" rel="stylesheet" type="text/css" />
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
                $menuList = \think\facade\Cache::get("1341231557579bfea34d80b618a678ce");
            }
            $currid   = \think\facade\Cache::get("currid_1341231557579bfea34d80b618a678ce");
            
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

<div class="search_bgd">
  <div class="search_bg">
    <div class="search">
      <div class="search_l">
        <div class="search_l_txt">
          <span>一直专注土工合成材料领域</span><br>
厂家直销，免费邮递样品
        </div>
      </div>
      <div class="search_cen">
        <form action="<?php echo url('template/search'); ?>" target="_blank">
          <div class="search_cen_txt">
            <div id="search-bg"><input type="search" name="q" id="infoname"
                style=" height:26px; line-height:29px; padding-left:8px; border:none; outline: none"
                placeholder="请输入关键字" size="25"></div>
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
        <div class="search_r_txt">实力商家<br>
          品质保证
        </div>
      </div>
    </div>
  </div>
  <div class="search_bo"></div>
</div>
  <div id="bgr">
    <style>
      #bodycon #left {
        display: none;
      }

      #bodycon #center {
        width: 1200px !important;
      }

      .mianbxContent {
        width: 1200px !important;
      }

      div#right {
        display: none;
      }
    </style>

    <div id="banner_com"></div>
    <div id="bodycon">
        <div id="left" style="height: 760px;">
  <div class="list" data-scroll-reveal="enter left and move 50px over 0.5s" data-scroll-reveal-id="1"
    style="-webkit-transform: translatex(0);transform: translatex(0);opacity: 1;-webkit-transition: -webkit-transform 0.5s ease-in-out 0s,  opacity 0.5s ease-in-out 0s;transition: transform 0.5s ease-in-out 0s, opacity 0.5s ease-in-out 0s;-webkit-perspective: 1000;-webkit-backface-visibility: hidden;"
    data-scroll-reveal-initialized="true">
    <div class="list_t"><?php echo htmlentities($field['typename']); ?><br><span><?php echo htmlentities($field['typenameen']); ?></span></div>
    <div class="list_kb"></div>
    <div class="list_bg">
      <table width="219" border="0" cellspacing="0" cellpadding="0">
        <tbody>
         
        </tbody>
      </table>
    </div>
    <div class="list_kbx"></div>
  </div>
</div>
      <div id="center">
        <div id="bodycontent" class="mianbxContent" style="height:25px;width:90%;text-align:right;">
          您的位置:
          <?php echo $yy['field']['position']; ?>
        </div>
        <style>
          /*about*/
          .about {
            width: 100%;
            min-width: 1200px;
            padding: 40px 0;
            overflow: hidden;
          }

          .about_t {
            width: 100%;
            min-width: 1200px;
            padding: 10px 0 30px 0;
          }

          .about_tm,
          .about_t_s,
          .about_t_en {
            width: 1200px;
            margin: 0 auto;
            text-align: center;
          }

          .about_tm {
            font-size: 42px;
            font-weight: bold;
            color: #01a74d;
            line-height: 60px;
          }

          .about_t_line {
            width: 369px;
            overflow: hidden;
            margin: 10px auto;
          }

          .about_t_line_l {
            float: left;
            width: 11px;
            height: 11px;
            background: #ccc;
          }

          .about_t_line_z {
            float: left;
            background: #ccc;
            width: 347px;
            height: 1px;
            margin-top: 5px;
          }

          .about_t_s {
            font-size: 20px;
            line-height: 30px;
          }

          .about_t_en {
            font-family: Arial, Helvetica, sans-serif;
            text-transform: uppercase;
            font-size: 12px;
            color: #999;
            line-height: 20px;
          }

          .about_d {
            width: 1200px;
            margin: 0 auto;
            overflow: hidden;
            padding-top: 20px;
            padding-bottom: 20px;
            position: relative;
            margin-bottom: 40px;
          }

          .about_d_ro {
            width: 78px;
            overflow: hidden;
            left: 0;
            top: 0;
            position: absolute;
          }

          .about_d_ro_i {
            width: 22px;
            float: left;
            margin-left: 10px;
            overflow: hidden;
          }

          .about_d_ro_i span {
            width: 0;
            height: 0;
            display: block;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 40px solid #01a74d;
            transform: rotate(40deg);
            margin-bottom: -18px;
          }

          .about_d_ro_i strong {
            display: block;
            width: 22px;
            height: 22px;
            background: #01a74d;
          }

          .about_d_ri {
            width: 78px;
            overflow: hidden;
            margin-top: 160px;
            right: 0;
            bottom: 0;
            position: absolute;
          }

          .about_d_ri_i {
            width: 22px;
            float: left;
            margin-left: 10px;
            overflow: hidden;
          }

          .about_d_ri_i span {
            width: 0;
            height: 0;
            display: block;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 40px solid #01a74d;
            transform: rotate(-140deg);
            margin-top: -20px;
            margin-left: 6px;
          }

          .about_d_ri_i strong {
            display: block;
            width: 22px;
            height: 22px;
            background: #01a74d;
          }

          .about_d_rn {
            width: 1030px;
            margin: 0 auto;
            line-height: 28px;
            font-size: 15px;
            padding-left: 10px;
          }

          .about_d_rn a {
            font-weight: bold;
            font-size: 14px;
            color: #de0000;
          }

          .about_img {
            width: 1200px;
            margin: 0 auto;
            overflow: hidden;
            text-align: center;
          }
        </style>
        <!--简介 about-->
        <div class="about_t_en">
        </div>
        <div class="about_d">
          <div class="about_d_ro">
            <div class="about_d_ro_i"><span></span><strong></strong></div>
            <div class="about_d_ro_i"><span></span><strong></strong></div>
          </div>
          <div class="about_d_rn">
          <?php echo $yy['field']['content']; ?>
</div>
          <div class="about_d_ri">
            <div class="about_d_ri_i"><strong></strong><span></span></div>
            <div class="about_d_ri_i"><strong></strong><span></span></div>
          </div>
        </div>
        <div>
          <div class="about_img"><img src="/skin/images/about.jpg" alt="" /></div>
        </div>
        <div id="bodycontent" style="height:10px;"></div>
        <div id="bodycontent">
        </div>
      </div>
      <div id="right">
      </div>
      <div class="clear"></div>
    </div>
    <div id="copy"></div>
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
                $menuList = \think\facade\Cache::get("9faa7eee1bff3a171a1dfe1c221043a5");
            }
            $currid   = \think\facade\Cache::get("currid_9faa7eee1bff3a171a1dfe1c221043a5");
            
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
  <script src="/skin/js/scrollreveal.js"></script>
</body>
</html>