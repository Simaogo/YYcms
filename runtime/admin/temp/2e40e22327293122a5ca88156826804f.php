<?php /*a:3:{s:53:"E:\WWW\tp6dedecms\template\admin\channeltype\add.html";i:1633766034;s:51:"E:\WWW\tp6dedecms\template\admin\public\header.html";i:1633268996;s:51:"E:\WWW\tp6dedecms\template\admin\public\footer.html";i:1633685531;}*/ ?>
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

<form class="layui-form" action="" lay-filter="list">
    <div class="layui-row" style="padding: 15px;margin-bottom: 35px">
          <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
              <input type="text" name="typename" lay-verify="title" autocomplete="off" placeholder="请输入名称" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-inline">
              <label class="layui-form-label">ID</label>
              <div class="layui-input-inline">
                    <input type="text" name="id" lay-verify="required" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-inline">
              <label class="layui-form-label">模型标识</label>
              <div class="layui-input-inline">
                <input type="text" name="nid" lay-verify="required" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>
         <div class="layui-form-item">
            <div class="layui-inline">
              <label class="layui-form-label">主表</label>
              <div class="layui-input-inline">
                    <input type="text" name="maintable" lay-verify="required" autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-inline">
              <label class="layui-form-label">附表</label>
              <div class="layui-input-inline">
                <input type="text" name="addtable" lay-verify="required" autocomplete="off" class="layui-input">
              </div>
            </div>
          </div>
         <div class="layui-form-item">
            <label class="layui-form-label">字段</label>
            <div class="layui-input-block">
              <input type="text" name="listfields" lay-verify="title" autocomplete="off" placeholder="请输入字段" class="layui-input">
            </div>
          </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">字段设置</label>
            <div class="layui-input-block">
              <textarea placeholder="请输入字段设置" class="layui-textarea" name="fieldset"></textarea>
            </div>
          </div>
        <div class="layui-form-item layui-flex layui-submit" style="">
            <button class="layui-btn" lay-submit="" lay-filter="submit" style="width:150px;margin: 0 auto;">提交保存</button>
        </div>
</div>
</form>
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
<script>

</script>