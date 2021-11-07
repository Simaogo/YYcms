<?php /*a:5:{s:53:"E:\WWW\tp6dedecms\app\admin\view\admin_log\index.html";i:1636295755;s:5:"param";i:0;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1636280202;s:50:"E:\WWW\tp6dedecms\app\admin\view\public\table.html";i:1636281698;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1636293469;}*/ ?>
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
<body style="padding-left: 5px;">

<div class="layui-row">
    <div class="layui-col-md12 layui-card">
        <table class="layui-hide" id="list" lay-filter="list"></table>
    </div>
</div>

 <script src="/yyAdmin/layui/layui.js"></script>
<!-- jQuery JS -->
<script type="text/html" id="toolbar">
  <div class="layui-btn-container">
    <button class="layui-btn layui-btn-sm" lay-event="add">添加</button>
    <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="delAll">删除</button>
  </div>
</script>

<script>
    window.formData = <?php echo isset($formData)?(json_encode($formData)):'""'; ?>,
    window.url = window.location.href,//当前URL
    window.yyadminPath ='/yyAdmin'; 
    window.addEditUrl = '<?php echo url(lcfirst(request()->controller())."/addEdit"); ?>',
    window.rowEditUrl = '<?php echo url(lcfirst(request()->controller())."/rowEdit"); ?>',
    window.uploadUrl = '<?php echo url("ajax/uploads"); ?>',
    window.delUrl = '<?php echo url(lcfirst(request()->controller())."/del"); ?>';
    window.delAllUrl = '<?php echo url(lcfirst(request()->controller())."/delAll"); ?>';
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
          ,url: url //数据接口
          ,page: true //开启分页
           ,toolbar: '#toolbar' 
           ,defaultToolbar: ['filter', 'exports', 'print', {
              title: '提示'
              ,layEvent: 'LAYTABLE_TIPS'
              ,icon: 'layui-icon-tips'
            }]
          ,cols: [[ //表头
            {type:'checkbox'}      
            ,{field: 'id', title: 'ID', width:60, sort: true}
            ,{field:'username', title:'用户',width:100,edit:true}
            ,{field: 'title', title:'标题', width:100,sort: true,align:'center'}
            ,{field: 'url', title: 'url', width:250,sort: true,align:'center'}
            ,{field: 'method', title: 'method', width:120,sort: true,align:'center'}
            ,{field: 'ip', title: 'ip', width:150,sort: true,align:'center'}
            ,{field: '', title: '数据', width:200,sort: true,align:'center',templet:function(d){
                    if(d.post_data && d.post_data!='[]'){
                        return d.post_data;
                    }else{
                        return d.get_data;
                    }
            }}
            ,{field: 'create_time', title: '操作时间', width:250,sort: true,align:'center'}
            ,{field: '', title: '操作', width:120,align:'center',templet:tableTool.templet.operate}
          ]]
        ,limit:15
        });
        tableTool.events.operate();
        tableTool.events.toolbar();
    });
</script>