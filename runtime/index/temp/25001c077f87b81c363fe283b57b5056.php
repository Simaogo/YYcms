<?php /*a:7:{s:37:"../template/default/index_article.htm";i:1634557795;s:5:"param";s:25:"a:1:{s:3:"tid";s:2:"12";}";s:28:"../template/default/head.htm";i:1634559396;s:30:"../template/default/banner.htm";i:1634557794;s:32:"../template/default/position.htm";i:1634558479;s:28:"../template/default/left.htm";i:1634558558;s:30:"../template/default/footer.htm";i:1634557794;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
<title><?php echo htmlentities($info['typename']); ?>_<?php echo syscfg('cfg_webname'); ?></title>
<meta name="keywords" content="<?php echo htmlentities($info['keywords']); ?>" />
<meta name="description" content="{yycms:field name='description' /}" />
<script type="text/javascript" src="/skin/js/jquery-1.12.4.min.js"></script>
<link rel="stylesheet" href="/skin/css/style.css">
<link rel="stylesheet" href="/skin/css/font-awesome.min.css">
<script type="text/javascript" src="/skin/js/js.js"></script>
<script type="text/javascript" src="/skin/js/superslide.js"></script>
</head>
<body>
<div class="iet">
    <p>您的浏览器版本过低，为保证更佳的浏览体验，<a href="https://www.imooc.com/static/html/browser.html">请点击更新高版本浏览器</a></p>
    <span class="closed">以后再说<i>X</i></span> </div>
<script type="text/javascript">
        $('.closed').click(function(){
            $('.iet').hide();
        })
    </script>
<div class="header">
    <div class="toptext">
        <div class="center clearfix">
            <p>欢迎访问贵州和诚纬企业管理有限公司网站！</p>
            <!--  <span>
                    <a href="javascript:;"><img src="/skin/images/china.png" alt="图片名"><i>中文</i></a>
                    <a href="javascript:;"><img src="/skin/images/english.png" alt="图片名"><i>English</i></a>
                </span> -->
        </div>
    </div>
    <div class="center">
        <div class="head_top clearfix">
            <div class="logo fl"> <a href="/"><img src="/skin/images/logo.jpg"></a>
                <p> <span>多年<i>认证咨询专家</i>贵州和诚纬企业管理</span><br/>
                    <small>IOS认证\AAA信用评价\知识产权认证\商品售后认证\产品认证</small> </p>
            </div>
            <div class="fr"> <img src="/skin/images/yw4.gif" alt="图片名">
                <p>全国订购热线：<br/>
                    <span><?php echo syscfg('cfg_tel'); ?></span>
                    <span><?php echo syscfg('cfg_phone'); ?></span>
                    </p>
            </div>
        </div>
    </div>
    <div class="nav" id="nav">
        <div class="center">
            <ul id="pc_nav">
                <li><a href="/">网站首页</a></li>
				<?php 
            if(isset($typeid)){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$typeid];
                $menuList =\app\common\model\Arctype::where($where)->select();
                $menuList = $menuList ? $menuList->toArray():\think\facade\Cache::get("49af58c6ca3e3d89dd61e76d16517f2c"); 
            }else{
                $menuList = \think\facade\Cache::get("49af58c6ca3e3d89dd61e76d16517f2c");
            }
            $currid   = \think\facade\Cache::get("currid_49af58c6ca3e3d89dd61e76d16517f2c");
            foreach($menuList as $index=>$field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
                    $field["currentstyle"] = in_array($field["id"],$currid)?"active":"";//栏目显示高亮
            ?>
                <li ><a href='<?php echo htmlentities($field['typeurl']); ?>' class="<?php echo htmlentities($field['currentstyle']); ?>"><?php echo htmlentities($field['typename']); ?></a></li>
				<?php } ?>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
            $("#pc_nav a").each(function(){
                if ($(this)[0].href == String(window.location) && $(this).attr('href')!="") {
                    $(this).addClass("active");
                }
            });
        </script>
    <script type="text/javascript">
            $(document).ready(function() {
                var navOffset=$("#nav").offset().top;
                $(window).scroll(function(){
                    var scrollPos=$(window).scrollTop();
                    if(scrollPos >=navOffset){
                        $("#nav").addClass("fixed");
                        $("#navi").addClass("full");
                    }else{
                        $("#nav").removeClass("fixed");
                        $("#navi").removeClass("full");
                    }
                });
            });
        </script>
</div>
<div class="m_header">
    <div class="m_head_content">
        <div class="m_head_logo"> <a href="/"><img src="/skin/images/logo-m.png"></a> </div>
        <div class="language">
            <!-- <span>
                    <a href="javascript:;"><img src="/skin/images/china.png" alt="图片名"><i>中文</i></a>
                    <a href="javascript:;"><img src="/skin/images/english.png" alt="图片名"><i>English</i></a>
                </span>-->
        </div>
        <div class="menu" id="menu"><i class="fa fa-list-ul"></i></div>
    </div>
    <div class="app_menu" id="app_menu">
        <ul>
            <li><a href="/"><span>网站首页</span></a></li>
			<?php 
            if(isset($typeid)){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$typeid];
                $menuList =\app\common\model\Arctype::where($where)->select();
                $menuList = $menuList ? $menuList->toArray():\think\facade\Cache::get("49af58c6ca3e3d89dd61e76d16517f2c"); 
            }else{
                $menuList = \think\facade\Cache::get("49af58c6ca3e3d89dd61e76d16517f2c");
            }
            $currid   = \think\facade\Cache::get("currid_49af58c6ca3e3d89dd61e76d16517f2c");
            foreach($menuList as $index=>$field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
                    $field["currentstyle"] = in_array($field["id"],$currid)?"active":"";//栏目显示高亮
            ?>
            <li><a href='<?php echo htmlentities($field['typeurl']); ?>' ><span><?php echo htmlentities($field['typename']); ?></span></a></li>
			<?php } ?>        </ul>
        <script type="text/javascript">
                $("#menu").on('click', function (event) {
                    if($("#app_menu").css("display")=="none"){
                        $("#app_menu").slideDown(600);
                    }else{
                        $("#app_menu").slideUp(600);
                    }
                });
            </script>
    </div>
</div>

<div class="page_banner"> <img src="/skin/images/nybanner.jpg" /> </div>
<div class="m_banner mtbanner">
    <div class="mbanner" id="mbanner">
        <ul>
            <li><img src="/skin/images/b_m_1.jpg"></li>
            <li><img src="/skin/images/b_m_2.jpg"></li>
        </ul>
    </div>
    <script type="text/javascript">
            $(function () {
                $('#mbanner').roll({
                    banner: true,
                    btn: true
                });
            });
        </script>
</div>

<div class="container">
    <div class="curson">
        <div class="center">
            <p> <?php echo $info['position']; ?> </p>
            <span><?php echo htmlentities($info['typename']); ?></span> 
		</div>
    </div>
    <div class="m_pagemenu"> 
	    <?php 
            if(isset($typeid)){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$typeid];
                $menuList =\app\common\model\Arctype::where($where)->select();
                $menuList = $menuList ? $menuList->toArray():\think\facade\Cache::get("16f0dbb828f6225fe62ada259e64bf20"); 
            }else{
                $menuList = \think\facade\Cache::get("16f0dbb828f6225fe62ada259e64bf20");
            }
            $currid   = \think\facade\Cache::get("currid_16f0dbb828f6225fe62ada259e64bf20");
            foreach($menuList as $index=>$field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
                    $field["currentstyle"] = in_array($field["id"],$currid)?"active":"";//栏目显示高亮
            ?>
		<a href="<?php echo htmlentities($field['typeurl']); ?>" class="<?php echo htmlentities($field['currentstyle']); ?>"><?php echo htmlentities($field['typename']); ?></a> 
		<?php } ?>
	</div>
    <div class="center">
        <div class="wrap clearfix"> <div class="main_l fl">
    <h3><?php echo htmlentities($info['typenameen']); ?></h3>
    <i></i> <span><?php echo htmlentities($info['typename']); ?></span>
    <ul class="page_menu">
	    <?php 
            if(isset($typeid)){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$typeid];
                $menuList =\app\common\model\Arctype::where($where)->select();
                $menuList = $menuList ? $menuList->toArray():\think\facade\Cache::get("16f0dbb828f6225fe62ada259e64bf20"); 
            }else{
                $menuList = \think\facade\Cache::get("16f0dbb828f6225fe62ada259e64bf20");
            }
            $currid   = \think\facade\Cache::get("currid_16f0dbb828f6225fe62ada259e64bf20");
            foreach($menuList as $index=>$field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
                    $field["currentstyle"] = in_array($field["id"],$currid)?"active":"";//栏目显示高亮
            ?>
        <li ><a href='<?php echo htmlentities($field['typeurl']); ?>' class="<?php echo htmlentities($field['currentstyle']); ?>"><?php echo htmlentities($field['typename']); ?></a></li>
        <?php } ?>
    </ul>
</div>

            <div class="main_r fr">
                <div class="page_content">
                    <div class="page_tit">
                        <h3><?php echo htmlentities($info['typename']); ?></h3>
                    </div>
                    <div class="content"> <?php echo $info['content']; ?> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="center">
        <div class="foot clearfix">
            <div class="foot_contact fl">
                <h3>联系我们</h3>
                <span><strong><?php echo syscfg('cfg_tel'); ?></strong>Sale Hotline</span>
                <p><?php echo syscfg('cfg_add'); ?></p>
                <p>邮箱：<?php echo syscfg('cfg_email'); ?></p>
                <p>电话：<?php echo syscfg('cfg_phone'); ?></p>
                <p>传真：<?php echo syscfg('cfg_fax'); ?></p>
                <a href="<?php $field= \think\facade\Cache::get("typeinfo_1");$field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);$field["typeurl"] = \think\facade\Config::get("app.list_url") ."". $field["id"]; ?><?php echo htmlentities($field['typeurl']); ?>">了解更多</a> </div>
            <div class="foot_ewm fl">
                <p>"精益求精，诚信为本"</p>
                <div class="ewm_text"> <img src="/skin/images/weixin.jpg" /> <span>微信公众号</span> </div>
                <!--<div class="ewm_text"> <img src="/skin/images/m.jpg" /> <span>移动端网站</span> </div>-->
            </div>
            <div class="foot_nav fl">
                <ul>
                    <h3>网站导航</h3>
					<?php 
            if(isset($typeid)){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$typeid];
                $menuList =\app\common\model\Arctype::where($where)->select();
                $menuList = $menuList ? $menuList->toArray():\think\facade\Cache::get("cfcd208495d565ef66e7dff9f98764da"); 
            }else{
                $menuList = \think\facade\Cache::get("cfcd208495d565ef66e7dff9f98764da");
            }
            $currid   = \think\facade\Cache::get("currid_cfcd208495d565ef66e7dff9f98764da");
            foreach($menuList as $index=>$field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
                    <li><a href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a></li>
					<?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="copyright">
    <div class="center">
        <p>
        <p><?php echo syscfg('cfg_powerby'); ?> 备案号：<a href="http://beian.miit.gov.cn/"  target="_blank" rel="nofollow"><?php echo syscfg('cfg_beian'); ?></a> <a href="/sitemap.html">网站地图</a></p>
        </p>
    </div>
</div>
<div class="kefu" id="kefu">
    <p> <img src="/skin/images/ff.png" alt="图片名"> <span>客服</span> </p>
    <div class="float_img">
        <div class="qq" id="qq"> <span>在线客服</span> <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo syscfg('cfg_qq'); ?>&site=qq&menu=yes;">客服一号</a> <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo syscfg('cfg_qq'); ?>&site=qq&menu=yes">客服二号</a> <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo syscfg('cfg_qq'); ?>&site=qq&menu=yes">客服三号</a> </div>
    </div>
</div>
<script type="text/javascript">
        $(function () {
            $('.imgauto img').imgAuto();
        })
    </script>
<script type="text/javascript">
        var browser=navigator.appName
        var b_version=navigator.appVersion
        var version=b_version.split(";");
        var trim_Version=version[1].replace(/[ ]/g,"");
        if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE6.0") {
            $('.iet').show();
        }else if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE7.0") {
            $('.iet').show();
        }else if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE8.0") {
            $('.iet').show();
        }else if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE9.0") {
            $('.iet').hide();
        } else {
            $('.iet').hide();
        }
    </script>

</body>
</html>