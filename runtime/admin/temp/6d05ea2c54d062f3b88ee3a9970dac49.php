<?php /*a:2:{s:49:"E:\WWW\tp6dedecms\app\admin\view\index\index.html";i:1636285911;s:5:"param";i:0;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title> YYadmin-<?php echo syscfg('cfg_webname'); ?></title>
    <!-- layui样式 -->
    <link rel="stylesheet" href="/yyAdmin/layui/css/layui.css">
    <!-- Y-Admin核心样式 -->
    <link rel="stylesheet" href="/yyAdmin/css/yadmin.css">
    <!-- 公共样式 -->
    <link rel="stylesheet" href="/yyAdmin/css/common.css">
    <!-- 图标 -->
    <link rel="stylesheet" href="/yyAdmin/static/remixicon/fonts/remixicon.css">
    <!-- 首页样式（只为此页面使用） -->
    <link rel="stylesheet" href="/yyAdmin/css/index.css">
</head>

<body class="layui-layout-body">

    <div class="layui-layout layui-layout-admin">

        <div class="layui-header">
            <!-- logo 区域 -->
            <div class="layui-logo">
                <a href="">
                    <img src="/yyAdmin/images/security.png" alt="logo" style="margin-left: -5px;" />
                    <cite style='color: #fff'>
                        YY-Admin&emsp;
                    </cite>
                </a>
            </div>

            <!-- 头部区域 -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item" lay-unselect>
                    <a lay-event="flexible" title="侧边伸缩">
                        <i class="layui-icon layui-icon-shrink-right"></i>
                    </a>
                </li>
                <!-- 面包屑 -->
                <span class="layui-breadcrumb layui-anim layui-anim-up">
                    <a><cite>首页</cite></a>
                </span>
            </ul>

            <!-- 头像区域 -->
            <ul class="layui-nav layui-layout-right">


                <li class="layui-nav-item feature-items">
                    <a lay-event="website" title="前台">
                        <i class="ri-earth-line"></i> 网站首页
                    </a>
                </li>

                <li class="layui-nav-item feature-items">
                    <a lay-event="clear" title="清理标签缓存"><i class="ri-brush-3-line"></i> 清理缓存</a>
                </li>
<!--                <li class="layui-nav-item feature-items">
                    <a lay-event="github" title="Github 地址">
                        <i class="ri-github-fill"></i>
                    </a>
                </li>-->
<!--                <li class="layui-nav-item feature-items">
                    <a lay-event="tag" title="便签"><i class="ri-git-repository-line"></i></a>
                </li>

                <li class="layui-nav-item feature-items">
                    <a lay-event="todo" title="待处理任务"><i class="ri-calendar-todo-line"></i></a>
                </li>-->

                <li class="layui-nav-item feature-items">
                    <a id="screenFull" lay-event="screenFull" title="全屏">
                        <i class="ri-fullscreen-line"></i>
                    </a>
                    <a id="screenRestore" lay-event="screenRestore" title="退出全屏" style="display: none;">
                        <i class="ri-fullscreen-exit-line"></i>
                    </a>
                </li>

                <li class="layui-nav-item user-selection">
                    <a>
                        <img src="/yyAdmin/images/avatar.png" class="layui-nav-img" alt="头像">
                        <cite><?php echo htmlentities($admin['userid']); ?></cite>
                        <span class="layui-nav-more"></span>
                    </a>
                    <dl class="layui-nav-child">
<!--                        <dd lay-unselect>
                            <a lay-event="userInfo">基本资料</a>
                        </dd>-->
                        <dd lay-unselect>
                            <a lay-event="editPwd">修改密码</a>
                        </dd>
                        <hr>
                        <dd lay-unselect>
                            <a href="<?php echo url('admin/loginOut'); ?>">退出</a>
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>

        <!-- 左侧导航区域 -->
        <div class="layui-side ">
            <div class="layui-side-scroll">
                <ul class="layui-nav layui-nav-tree" lay-filter="lay-nav" lay-accordion="true">
                    <li class="layui-nav-item">
                        <a lay-url="<?php echo url('index/home'); ?>" lay-id="<?php echo url('index/home'); ?>">
                            <i class="ri-home-8-line"></i>&emsp;<cite>首页</cite>
                        </a>
                    </li>
                    <li class="layui-nav-item">
                        <a lay-id="javascript:;" lay-url="javascript:;">
                             <i class="ri-settings-4-line"></i>&emsp;<cite>系统管理</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd>
                                <a lay-id="<?php echo url('config/index'); ?>" lay-url="<?php echo url('config/index'); ?>">
                                    <cite>系统设置</cite>
                                </a>
                            </dd>
                            <dd>
                                <a lay-id="<?php echo url('adminLog/index'); ?>" lay-url="<?php echo url('adminLog/index'); ?>">
                                    <cite>管理员日志</cite>
                                </a>
                            </dd>
                            <dd>
                                <a lay-id="#" lay-url="#">
                                    <cite>配置</cite>
                                </a>
                            </dd>
                            <dd>
                                <a lay-id="#" lay-url="#">
                                    <cite>配置组</cite>
                                </a>
                            </dd>
                            
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a lay-id="javascript:;" lay-url="javascript:;">
                            <i class="ri-shield-keyhole-line"></i>&emsp;<cite>权限管理</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd>
                                <a lay-id="<?php echo url('admin/index'); ?>" lay-url="<?php echo url('admin/index'); ?>">
                                    <cite>用户管理</cite>
                                </a>
                            </dd>
                            <dd>
                                <a lay-id="<?php echo url('admintype/index'); ?>" lay-url="<?php echo url('admintype/index'); ?>">
                                    <cite>角色管理</cite>
                                </a>
                            </dd>
                            <dd>
                                <a lay-id="<?php echo url('authRule/index'); ?>" lay-url="<?php echo url('authRule/index'); ?>">
                                    <cite>菜单权限</cite>
                                </a>
                            </dd>
                        </dl>
                    </li>

                    <li class="layui-nav-item">
                        <a lay-id="javascript:;" lay-url="javascript:;">
                            <i class="ri-menu-add-line"></i>&emsp;<cite>内容管理</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-id="<?php echo url('arclist/index'); ?>" lay-url="<?php echo url('arclist/index'); ?>"><cite>文档列表</cite></a></dd>
                            <dd><a lay-id="<?php echo url('arctype/index'); ?>" lay-url="<?php echo url('arctype/index'); ?>"><cite>栏目管理</cite></a></dd>
                            <dd><a lay-id="<?php echo url('channeltype/index'); ?>" lay-url="<?php echo url('channeltype/index'); ?>"><cite>模型管理</cite></a></dd>
                            <dd><a lay-id="<?php echo url('flink/index'); ?>" lay-url="<?php echo url('flink/index'); ?>"><cite>友情链接</cite></a></dd>
                            <dd><a lay-id="<?php echo url('diyforms/index'); ?>" lay-url="<?php echo url('diyforms/index'); ?>"><cite>留言管理</cite></a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a lay-id="javascript:;" lay-url="javascript:;">
                            <i class="ri-mail-download-fill"></i>&emsp;<cite>广告管理</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-id="<?php echo url('myppttype/index'); ?>" lay-url="<?php echo url('myppttype/index'); ?>"><cite>广告分类</cite></a></dd>
                            <dd><a lay-id="<?php echo url('myppt/index'); ?>" lay-url="<?php echo url('myppt/index'); ?>"><cite>广告列表</cite></a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a lay-id="javascript:;" lay-url="javascript:;">
                            <i class="ri-tools-fill"></i>&emsp;<cite>工具管理</cite>
                        </a>
                         <dl class="layui-nav-child">
                            <dd><a lay-id="<?php echo url('tool/index'); ?>" lay-url="<?php echo url('tool/index'); ?>"><cite>替换内容</cite></a></dd>
                            <dd><a lay-id="<?php echo url('setsql/index'); ?>" lay-url="<?php echo url('setsql/index'); ?>"><cite>数据库操作</cite></a></dd>
                         </dl>
                    </li>
                    
                </ul>

<!--                <div id="message">
                    <div class="notification-box" lay-event="notification">
                        <span class="notification-count">
                             此处可写数字 
                        </span>
                        <div class="notification-bell">
                            <span class="bell-top"></span>
                            <span class="bell-middle"></span>
                            <span class="bell-bottom"></span>
                            <span class="bell-rad"></span>
                        </div>
                    </div>
                    <h3>消息通知</h3>
                    <p>春已至,花已开,一切美好都将到来!</p>
                </div>-->

            </div>
        </div>

        <div class="layui-body">
            <div class="layui-pagetabs">
                <div class="layui-icon admin-tabs-control layui-icon-refresh-3" lay-event="refresh"></div>
                <div class="layui-tab" lay-unauto lay-allowclose="true" lay-filter="lay-tab">
                    <ul class="layui-tab-title">
                        <li lay-id="<?php echo url('index/home'); ?>" lay-url="<?php echo url('index/home'); ?>" class="layui-this">
                            <!-- <i class="ri-home-heart-line ri-xl"></i> -->
                            <i class="ri-home-8-line ri-xl"></i>
                        </li>
                    </ul>
                    <div class="layui-tab-content">
                        <div class="layui-tab-item layui-show">
                            <iframe src="<?php echo url('index/home'); ?>" class="layui-iframe"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 底部固定区域 -->
        <div class="layui-footer">
            copyright © 2021 YY-Admin all rights reserved.
            <!--<ul class="tabbar">
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M12.414 5H21a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h7.414l2 2zM15 13v-1a3 3 0 0 0-6 0v1H8v4h8v-4h-1zm-2 0h-2v-1a1 1 0 0 1 2 0v1z" />
                    </svg>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M21 5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h7.414l2 2H16v2h2V5h3zm-3 8h-2v2h-2v3h4v-5zm-2-2h-2v2h2v-2zm2-2h-2v2h2V9zm-2-2h-2v2h2V7z" />
                    </svg>
                </li>
                <li>
                    <div class="fileAdd">
                        <ul>
                            <li class="word"></li>
                            <li class="powerpoint"></li>
                            <li class="excel"></li>
                        </ul>
                        <div>
                            <span></span>
                        </div>
                    </div>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M12.414 5H21a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h7.414l2 2zM11 13.05a2.5 2.5 0 1 0 2 2.45V11h3V9h-5v4.05z" />
                    </svg>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M12.414 5H21a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h7.414l2 2zM12 13a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm-4 5h8a4 4 0 1 0-8 0z" />
                    </svg>
                </li>
            </ul>-->

        </div>

        <!-- 移动端遮罩 -->
        <div class="site-mobile-shade"></div>
    </div>
    <script>
       window.clearRuntimeUrl = '<?php echo url("index/clear"); ?>';//清除缓存URL
       window.editPasswordUrl = '<?php echo url("index/editPassword"); ?>';//修改密码
       window.homeUrl = '<?php echo url("index/clear"); ?>';//homeURL
       window.yyAdminPath = '/yyAdmin';//yyadmin.js URL
    </script>
    <!-- layui JS -->
    <script src="/yyAdmin/layui/layui.js"></script>
    <!-- 公共JS -->
    <script src="/yyAdmin/js/common.js"></script>
</body>
</html>