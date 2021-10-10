<?php /*a:1:{s:48:"E:\WWW\tp6dedecms\template\admin\index\home.html";i:1633790310;}*/ ?>
<html lang="en"><head>
    <meta charset="utf-8">
    <title>后台首页</title>
    <meta property="og:keywords" content="FunAdmin,LAYUI,THINKPHP6">
    <meta property="og:description" content="FunAdmin,LAYUI,THINKPHP6,Require">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="referrer" content="never">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
    <script src="/static/layui/layui.js" charset="utf-8"></script>
    <!--[if lt IE 9]>
        <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
        <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body style="padding: 10px;background: #fff">
<table class="layui-table" lay-skin="line">
    <thead>
    <tr>
        <th>系统信息</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>当前版本：YYcms <?php echo htmlentities($now_version); ?>&nbsp;&nbsp;
            <button id="upgrade" class="layui-btn layui-btn-sm layui-btn-warm" >点此检测版本</button>
        </td>
    </tr>
    <tr>
        <td>服务器域名：<?php echo htmlentities($url); ?></td>
    </tr>
    <tr>
        <td>服务器ip：<?php echo htmlentities($server_ip); ?></td>
    </tr>
    <tr>
        <td>站点目录：<?php echo htmlentities($document_root); ?></td>
    </tr>
    <tr>
        <td>当前协议：<?php echo htmlentities($document_protocol); ?></td>
    </tr>
    <tr>
        <td>端口：<?php echo htmlentities($server_port); ?></td>
    </tr>
    <tr>
        <td>PHP版本：<?php echo htmlentities($php_version); ?></td>
    </tr>
    <tr>
        <td>数据库版本：<?php echo htmlentities($mysql_version); ?></td>
    </tr>
    <tr>
        <td>Nginx：<?php echo htmlentities($server_soft); ?></td>
    </tr>
    <tr>
        <td>服务器时间：<?php echo date('Y-m-d H:i:s'); ?></td>
    </tr>
    </tbody>
</table>
<script>
    
    layui.use(['table','layer'], function(){
        var table = layui.table
        ,layer = layui.layer;
          layui.$('#upgrade').click(function(){
              layer.confirm('确定升级到最新版本？', function(index){
                    var data = {};
                    var index = layer.load(1, {
                      shade: [0.3, '#333'], content: '升级数据加载中!<br>耐心等待不要关闭该窗口!', success: function (layero) {
                                layero.find('.layui-layer-content').css({
                                        'padding-top': '6px',
                                        'width': '180px',
                                        'padding-left': '40px',
                                        'color' :'#FFF'
                                });
                                layero.find('.layui-layer-ico16, .layui-layer-loading .layui-layer-loading2').css({
                                        'width': '150px !important',
                                        'background-position': '2px 0 !important'
                                });
                        }
                    });
                    layui.$.post("<?php echo url('index/install'); ?>",data,function(res){
                         if(res.code == 0) {
                             layer.closeAll('loading');
                             layer.msg(res.msg)
                         }
                     })
               })
          })
      });
</script>
</body>

</html>