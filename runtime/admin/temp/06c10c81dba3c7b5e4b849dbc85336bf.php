<?php /*a:3:{s:55:"E:\WWW\tp6dedecms\template\admin\channeltype\index.html";i:1633661119;s:51:"E:\WWW\tp6dedecms\template\admin\public\header.html";i:1633268996;s:51:"E:\WWW\tp6dedecms\template\admin\public\footer.html";i:1633853083;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>栏目管理</title>
  <link rel="stylesheet" href="/static/layui/css/layui.css">
  <link rel="stylesheet" href="/static/admin/css/common.css">
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
      
<script src="/static/layui/layui.js"></script>
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
    window.addEditUrl = window.location.href,
    window.url = window.location.href,         
    window.STATIC ='/static/admin'
    window.ADDONS = '__ADDONS__'
    window.PLUGINS = '/static/plugins';
    if(formData){
        layui.form.val('list',formData);//赋值
    }
    console.log(formData);
    //form公共提交
    layui.use(['form', 'jquery','table','element'], function(){
      var form = layui.form
      ,layer = layui.layer
      ,table = layui.table
      ,element = layui.element
      ,$ = layui.jquery;
      //监听提交
      form.on('submit(submit)', function(obj){
        var data =obj.field;
        $.post(url,data,function(res){
            layer.msg(res.msg,{time:600},function(){
                  parent.layui.table.reload('list');
                  var index = parent.layer.getFrameIndex(window.name);  
                  parent.layer.close(index);
            })
        })
        return false;
      });
        //监听行工具事件
       table.on('tool(list)', function(obj){
             var data = obj.data;
             if(obj.event === 'del'){
                layer.confirm('真的删除么', function(index){
                     $.post("<?php echo url(request()->controller().'/del'); ?>",data,function(res,index){
                         if(res.code==0) layer.msg(res.msg)
                     })
                     obj.del();
                     layer.close(index);
               })
             } else if(obj.event === 'edit'){
                layer.open({
                 type: 2,
                 title: '编辑',
                 shadeClose: true,
                 shade: 0.2,
                 maxmin: true, //开启最大化最小化按钮
                 area: ['85%', '85%'],
                 content: '<?php echo url(request()->controller()."/addEdit"); ?>?id='+data.id
               });
             }
         });
        //头工具栏事件
        table.on('toolbar(list)', function(obj){
          var checkStatus = table.checkStatus(obj.config.id);
          switch(obj.event){
            case 'add':
              layer.open({
                  type: 2,
                  title: '添加',
                  shadeClose: true,
                  shade: 0.2,
                  maxmin: true, //开启最大化最小化按钮
                  area: ['85%', '85%'],
                  content: '<?php echo url(request()->controller()."/addEdit"); ?>'
               });
            break; 
            break;
            case 'getCheckLength':
              var data = checkStatus.data;
              layer.msg('选中了：'+ data.length + ' 个');
            break;
            case 'isAll':
              layer.msg(checkStatus.isAll ? '全选': '未全选');
            break;

            //自定义头工具栏右侧图标 - 提示
            case 'LAYTABLE_TIPS':
              layer.alert('这是工具栏右侧自定义的一个图标按钮');
            break;
          };
        });

    });
    layui.config({
        base: '../../static/layui/model/' //目录
      })
</script>
</body>
</html>
<script>
    layui.use('table', function(){
        var tree = layui.tree
        ,layer = layui.layer
        ,util = layui.util
        ,table = layui.table
        ,$ = layui.jquery;
        table.render({
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
              ,{field:'', width:180, title: '操作',templet:'#operate'}
            ]]
            ,limit:20
            ,page: true
        })
  })
</script>

