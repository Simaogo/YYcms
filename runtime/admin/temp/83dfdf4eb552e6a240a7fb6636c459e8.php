<?php /*a:3:{s:51:"E:\WWW\tp6dedecms\template\admin\arclist\index.html";i:1634138222;s:51:"E:\WWW\tp6dedecms\template\admin\public\header.html";i:1634202730;s:51:"E:\WWW\tp6dedecms\template\admin\public\footer.html";i:1634222788;}*/ ?>
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

<div class="layui-row" style='background: #f2f2f2;padding: 15px'>
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md2">
      <div class="layui-card">
        <div class="layui-card-header">栏目列表</div>
        
        <div class="layui-card-body">
            <div id="arctype" class="arctype-tree">
                
            </div>
        </div>
      </div>
    </div>
    <div class="layui-col-md10">
      <div class="layui-card">
        <div class="layui-card-header">内容管理</div>
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
            <input type="hidden" name="typeid" value="0">
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
    window.addEditUrl = window.location.href,
    window.url = window.location.href,         
    window.STATIC ='__STATIC__'
    window.ADDONS = '__ADDONS__'
    window.PLUGINS = '/static/plugins';
    //form公共提交
    layui.use(['form', 'jquery','table','element'], function(){
      var form = layui.form
      ,layer = layui.layer
      ,table = layui.table
      ,$ = layui.jquery;
       if(formData){
            layui.form.val('list',formData);//赋值
       }
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
    //上传
    var $ =layui.$;
    var uploadList = document.querySelectorAll("[lay-filter=\"upload\"]");
    if (uploadList.length > 0) {
        $.each(uploadList, function(i, v) {
            var _parent = $(this).parents('.layui-upload')
            var input = _parent.find('input[type="text"]');
            var uploadInst = layui.upload.render({
                elem: this //绑定元素
                ,url: '<?php echo url("ajax/uploads"); ?>' //上传接口
                ,done: function(res){
                  input.val(res.url);
                  layer.msg(res.msg)
                }
                ,error: function(){
                  //请求异常回调
               }
            })
        })
    }
    
    layui.config({
        base: "/yyAdmin/layui/lay/modules/"
    })
</script>
</body>
</html>

<script>
    layui.use(['table'], function(){
        var tree = layui.tree
        ,layer = layui.layer
        ,util = layui.util
        ,table = layui.table
        ,$ = layui.jquery,typeid;
        $.post('<?php echo url("arclist/arctypeList"); ?>',{},function(res){
            tree.render({
              elem: '#arctype'
              ,data: res.data
              ,onlyIconControl: true  //是否仅允许节点左侧图标控制展开收缩
              ,checked:true
              ,click: function(obj){
                    var typeid = obj.data.id;
                    arclist(typeid);
                    $('input[name="typeid"]').val(typeid);
              }
            });
        })

    var arclist =function(typeid){
        var url = '<?php echo url("arclist/index"); ?>?typeid='+typeid
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
              ,{field:'title', width:'20%', title: '标题'}
              ,{field:'', width:120, title: '栏目', sort: true,templet:function(d){return d.arctype.typename}}
              ,{field:'litpic', width:120, title: '缩略图', sort: true,templet:function(d){
                  return '<img src="'+d.litpic+'" style="height:45px;"class="image">'; 
               }}
              ,{field:'arcrank', width:120, title: '预览权限', sort: true}
              ,{field:'weight', width:80, title: '排序', sort: true}
//              ,{field:'senddate', width:180, title: '创建时间'}
              ,{field:'pubdate', width:180,title: '更新时间'}
              ,{field:'', width:"20%", title: '操作',templet:'#operate'}
            ]]
            ,limit:20
            ,page: true
        })
    }
    arclist(0);
    table.on('toolbar(list)', function(obj){
            var checkStatus = table.checkStatus(obj.config.id),
            id = checkStatus.data.id||0,
            typeid = $('input[name="typeid"]').val();
            switch(obj.event){
              case 'add':
                layer.open({
                    type: 2,
                    title: '编辑',
                    shadeClose: true,
                    shade: 0.2,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['85%', '85%'],
                    content: '<?php echo url(request()->controller()."/addEdit"); ?>?id='+id+'&typeid='+typeid
                });
              break;
              case 'getCheckData':
                var data = checkStatus.data;
                layer.alert(JSON.stringify(data));
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
  })
</script>

