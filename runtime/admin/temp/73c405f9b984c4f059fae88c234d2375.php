<?php /*a:3:{s:48:"E:\WWW\tp6dedecms\template\admin\tool\index.html";i:1633763193;s:51:"E:\WWW\tp6dedecms\template\admin\public\header.html";i:1633268996;s:51:"E:\WWW\tp6dedecms\template\admin\public\footer.html";i:1633685531;}*/ ?>
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

<div style="padding: 15px;">
    <table id="list" lay-filter="list"></table>
</div>
<div class="layui-row progress">
   <div class="layui-progress" lay-showPercent="true" lay-filter="progress">
        <div class="layui-progress-bar layui-bg-red" lay-percent="0/0"></div>
    </div>
 </div>
<style>
    .progress{
        width: 100%;
        position: fixed;
        left: 0;
        bottom: 0;
        display: none;
        z-index: 999;
    }
</style>
 
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
            case 'replaceTag'://替换模板标签
                var len = checkStatus.data.length,data;
                $('.progress').show();
                for(var i = 0;i<len;i++){
                    data =checkStatus.data[i]
                    ,data.page = i+1
                    ,data.count = len;
                    $.post('<?php echo url("tool/replaceTag"); ?>',data,function(res){
                        if(res.code == 0){
                            element.progress('progress',res.progress);
                            element.init();
                        }
                    })
                }   
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
<script type="text/html" id="tool">
  <div class="layui-btn-container">
    <button class="layui-btn layui-btn-sm" lay-event="replaceTag">一键换标签</button>
    <button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button>
    <button class="layui-btn layui-btn-sm" lay-event="isAll">验证是否全选</button>
  </div>
</script>
<script type="text/html" id="operateTool">
  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script>
    layui.use(['table','element'], function(){
      var table = layui.table
      ,element = layui.element;
        //第一个实例
        table.render({
          elem: '#list'
          ,height: '800'
          ,url: url //数据接口
          ,page: false //开启分页
           ,toolbar: '#tool' 
           ,defaultToolbar: ['filter', 'exports', 'print', {
              title: '提示'
              ,layEvent: 'LAYTABLE_TIPS'
              ,icon: 'layui-icon-tips'
            }]
          ,cols: [[ //表头
            {type:'checkbox'}      
            ,{field: 'id', title: '序号', width:80, sort: true}
            ,{field: 'filename', title: '文件名称', width:200,sort: true,align:'center'}
            ,{field: '', title: '操作', width:'35%',align:'center',templet:'#operateTool'}
          ]]
        });
        table.on('tool(list)', function(obj){
             var data = obj.data;
            if(obj.event === 'edit'){
                layer.open({
                 type: 2,
                 title: '编辑',
                 shadeClose: true,
                 shade: 0.2,
                 maxmin: true, //开启最大化最小化按钮
                 area: ['85%', '85%'],
                 content: '<?php echo url(request()->controller()."/addEdit"); ?>?filename='+data.filename
               });
             }
        })
    });
    
</script>