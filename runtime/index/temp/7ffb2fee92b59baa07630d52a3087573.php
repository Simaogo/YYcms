<?php /*a:5:{s:51:"E:\WWW\tp6dedecms\/template/simao/index_article.htm";i:1637118573;s:5:"param";s:24:"a:1:{s:3:"tid";s:1:"1";}";s:42:"E:\WWW\tp6dedecms\/template/simao/head.htm";i:1637113246;s:42:"E:\WWW\tp6dedecms\/template/simao/left.htm";i:1636881579;s:44:"E:\WWW\tp6dedecms\/template/simao/footer.htm";i:1637056096;}*/ ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?php echo htmlentities($yy['field']['title']); ?>_<?php echo syscfg('cfg_webname'); ?></title>
<meta name="keywords" content="<?php echo htmlentities($yy['field']['keywords']); ?>" />
<meta name="description" content="<?php echo htmlentities($yy['field']['description']); ?>" />
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
            $menuList = \think\facade\Cache::get("496f0c43173eec954b1552b96cc5a1b4");
            $currid   = \think\facade\Cache::get("currid_496f0c43173eec954b1552b96cc5a1b4");
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
                $menuList = \think\facade\Cache::get("9faa7eee1bff3a171a1dfe1c221043a5");
            }
            $currid   = \think\facade\Cache::get("currid_9faa7eee1bff3a171a1dfe1c221043a5");
            
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
<div class="ban img100">
    <div class="pc-show"><img src="<?php echo htmlentities($yy['field']['typeimg']); ?>"/></div>
    <div class="phone-show"><img src="<?php echo htmlentities($yy['field']['typeimg']); ?>"/></div>
</div>
<div class="position">
    <div class="w1240">
        <div class="gk-title">
            <h2><i><img src="/skin/images/h2-1.png"/></i><?php echo htmlentities($yy['field']['typename']); ?></h2>
        </div>
    </div>
</div>
<script type="text/javascript">
    var img1='<meta content="telephone=no" name="format-detection">';
    $('head').append(img1);
</script><div class="contentbox">
    <div class="w1240 relative">
        <div class="brief-nav">
	<div class="brief-nav-con">
		<ul>
<?php 
           
            if(isset($pid) && empty("0")){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$pid];
                $menuList =\app\common\model\Arctype::where($where)->limit(0,10)->select();
               
            }else{
                $menuList = \think\facade\Cache::get("35f9e54cb52e355869d02c2c2b4439bc");
            }
            $currid   = \think\facade\Cache::get("currid_35f9e54cb52e355869d02c2c2b4439bc");
            
            foreach($menuList as $key => $field){
                   $field["typeurl"] = $field["ispart"]== 2 && $field["sitepath"] ?$field["sitepath"] : \think\facade\Route::buildUrl("list",["tid"=>$field["id"]]);
                   $field["content"] = \fun\Process::getplaintextintrofromhtml($field["content"]);
		   $field["description"] = \fun\Process::getplaintextintrofromhtml($field["description"]);
                   $field["currentstyle"] = in_array($field["id"],$currid)?"
<li class='active'><i class='zksq actives'></i><a class='left-yi' href='~typeurl~'><div style='position: relative;z-index: 6;'>~typename~</div></a></li>
		":"";//栏目显示高亮
            ?>
 <li><i class="zksq"></i><a class="left-yi" href="<?php echo htmlentities($field['typeurl']); ?>"><div style="position: relative;z-index: 6;"><?php echo htmlentities($field['typename']); ?></div></a></li>	    	
		<?php } 
                    unset($field);
                 ?>
		</ul>
	</div>

</div> 
		<div class="box-right">
          <div class="margin-0 gywm-edit">
			<?php echo $yy['field']['content']; ?>
		  </div>
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
<script src="/skin/js/countup.js"></script>
</html>