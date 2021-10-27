<?php /*a:4:{s:55:"E:\WWW\tp6dedecms\app\admin\view\channeltype\index.html";i:1634995124;s:5:"param";i:0;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1634202730;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1635159586;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>页面管理</title>
      <!-- layui样式 -->
    <link rel="stylesheet" href="/yyAdmin/layui/css/layui.css">
    <!-- 公共样式 -->
    <link rel="stylesheet" href="/yyAdmin/css/common.css">
</head>
<body>

<div class="layui-row" style='background: #f2f2f2;'>
    <div class="layui-col-md12">
      <div class="layui-card">
        <div class="layui-card-header">模型管理</div>
        <div class="layui-card-body">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                  <div class="layui-flex">
                        <input type="text" name="title" required  lay-verify="required" placeholder="请输入标题关键词搜索" autocomplete="off" class="layui-input layui-col-md3" style='max-width: 350px;margin-right:5px;'>
                        <button type="button" class="layui-btn layui-btn-sm">搜索</button>
                  </div>
                </div>
            </form>
            <table class="layui-hide" id="list" lay-filter="list"></table>
        </div>
      </div>
    </div>
  </div>
</div>
      
 <script src="/yyAdmin/layui/layui.js"></script>
<!-- jQuery JS -->
<script type="text/html" id="toolbar">
  <div class="layui-btn-container">
    <button class="layui-btn layui-btn-sm" lay-event="add">添加</button>
    <button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button>
    <button class="layui-btn layui-btn-sm" lay-event="isAll">验证是否全选</button>
  </div>
</script>
<script type="text/html" id="operate">
  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script>
    window.formData = <?php echo isset($formData)?(json_encode($formData)):'""'; ?>,
    window.url = window.location.href,//当前URL
    window.yyadminPath ='/yyAdmin'; 
    window.addEditUrl = '<?php echo url(request()->controller()."/addEdit"); ?>',
    window.rowEditUrl = '<?php echo url(request()->controller()."/rowEdit"); ?>',
    window.uploadUrl = '<?php echo url("ajax/uploads"); ?>',
    window.delUrl = '<?php echo url(request()->controller()."/del"); ?>';
    layui.config({
        base: yyadminPath + "/js/"
    })
</script>
</body>
</html>
<script>
    layui.use('tableTool', function(){
        var tableTool = layui.tableTool;
        tableTool.render({
            elem: '#list'
            ,url:url
            ,toolbar: '#toolbar' 
            ,defaultToolbar: ['filter', 'exports', 'print', { 
              title: '提示'
              ,layEvent: 'LAYTABLE_TIPS'
              ,icon: 'layui-icon-tips'
            }]
            ,cols: [[
               {type:'checkbox'}
              ,{field:'id', width:80, title: 'ID', sort: true}
              ,{field:'nid', width:80, title: '标识'}
              ,{field:'typename', width:150, title: '名称'}
              ,{field:'maintable', width:150, title: '主表名称'}
              ,{field:'addtable', width:150, title: '附表名称'}
              ,{field:'listfields', width:'20%', title: '字段'}
               ,{field:'fieldset', width:'20%', title: '字段设置',type:'text'}
              ,{field:'isshow', width:80, title: '显示', sort: true}
              ,{field:'', width:180, title: '操作',templet:tableTool.templet.operate}
            ]]
            ,limit:20
            ,page: true
        })
        tableTool.events.operate();
        tableTool.events.toolbar();
  })
</script>

