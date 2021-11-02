<?php /*a:4:{s:52:"E:\WWW\tp6dedecms\app\admin\view\diyforms\index.html";i:1634994682;s:5:"param";i:0;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1634202730;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1635159586;}*/ ?>
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

<div class="layui-row">
    <div class="layui-col-md12" style="padding: 15px;">
        <table id="list" lay-filter="list"></table>
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
     layui.use(['tableTool'], function(){
      var tableTool = layui.tableTool;
        tableTool.render({
          elem: '#list'
          ,height: '800'
          ,url: url //数据接口
          ,page: false //开启分页
           ,toolbar: '#toolbar' 
           ,defaultToolbar: ['filter', 'exports', 'print', {
              title: '提示'
              ,layEvent: 'LAYTABLE_TIPS'
              ,icon: 'layui-icon-tips'
            }]
          ,cols: [[ //表头
            {type:'checkbox'}      
            ,{field: 'rank', title: 'ID', width:80, sort: true}
            ,{field: 'name', title: '在线留言', width:100,sort: true,align:'center'}
            ,{field: 'posttemplate', title: 'posttemplate', width:150,sort: true,align:'center'}
            ,{field: 'viewtemplate', title: 'viewtemplate', width:150,sort: true,align:'center'}
            ,{field: 'listtemplate', title: 'listtemplate', width:150,sort: true,align:'center'}
            ,{field: 'table', title: '数据库表名', width:150,sort: true,align:'center'}
            ,{field: 'data', title: '数据列表', width:'25%',sort: true,align:'center'}
            ,{field: '', title: '操作', width:'25%',align:'center',templet:tableTool.templet.operate}
          ]]
        });
        tableTool.events.operate();//操作事件
    });
</script>