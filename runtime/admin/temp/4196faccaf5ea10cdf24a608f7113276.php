<?php /*a:4:{s:51:"E:\WWW\tp6dedecms\app\admin\view\arclist\index.html";i:1636187394;s:5:"param";i:0;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1635936494;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1636185197;}*/ ?>
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
            <div id="arctype" class="arctype-tree" style='padding-bottom: 50px;'>
                
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
                        <button type="button" class="layui-btn layui-btn-sm" lay-filter="search" lay-submit="" >搜索</button>
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
    <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="delAll">删除</button>
  </div>
</script>
<script type="text/html" id="operate">
  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del" >删除</a>
</script>
<script>
    window.formData = <?php echo isset($formData)?(json_encode($formData)):'""'; ?>,
    window.url = window.location.href,//当前URL
    window.yyadminPath ='/yyAdmin'; 
    window.addEditUrl = '<?php echo url(request()->controller()."/addEdit"); ?>',
    window.rowEditUrl = '<?php echo url(request()->controller()."/rowEdit"); ?>',
    window.uploadUrl = '<?php echo url("ajax/uploads"); ?>',
    window.delUrl = '<?php echo url(request()->controller()."/del"); ?>';
    window.delAllUrl = '<?php echo url(request()->controller()."/delAll"); ?>';
    layui.config({
        base: yyadminPath + "/js/"
    })
</script>
</body>
</html>
<script>
    layui.use(['table','tableTool'], function(){
        var tree = layui.tree
        ,layer = layui.layer
        ,util = layui.util
        ,table = layui.table
        ,tableTool = layui.tableTool
        ,$ = layui.jquery;
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
    var arclist = function(typeid=0,title = ''){
        var url = '<?php echo url("arclist/index"); ?>?typeid='+ typeid ;
        if(title) url = '<?php echo url("arclist/index"); ?>?title='+ title;
        var tableConfig = {
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
              ,{field:'title', width:'30%', title: '标题'}
              ,{field:'', width:120, title: '栏目', sort: true,templet:function(d){return d.arctype.typename}}
              ,{field:'litpic', width:120, title: '缩略图', sort: true,templet:tableTool.templet.images}
              ,{field:'weight', width:80, title: '排序', sort: true,edit:true}
              ,{field:'pubdate', width:180,title: '更新时间',sort: true,}
              ,{field:'arcrank', width:120, title: '预览权限', sort: true,templet:tableTool.templet.switch}
              ,{field:'', width:180, title: '操作',templet:tableTool.templet.operate}
            ]]
            ,limit:20
            ,page: true
       }
       table.render(tableConfig);
    }
     arclist(0); //默认
     layui.form.on('submit(search)', function(obj){ //搜索标题
        var data =obj.field;
        arclist(0,data['title'])
        return false;
     });
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
                    content: '<?php echo url(request()->controller()."/addEdit"); ?>?id='+id+'&typeid='+ typeid
                });
              break;
              case 'delAll':
                var data = checkStatus.data;
                var len = data.length;
                var ids = [];
                for(var i = 0; i < len; i++){
                    ids.push(data[i].id);
                }
                layer.confirm('确定删除选中？', function(index){
                   $.post(delAllUrl,{ids:ids},function(res,index){
                       layer.msg(res.msg,{time:350},function(){
                           layer.close(index);
                           window.location.reload();
                       })
                   })
                   return false;
                })
              break;
            };
          });
        tableTool.events.switch ();//开关点击事件
        tableTool.events.rowEdit ();//编辑排序     
        tableTool.events.operate();//操作
        
     
  })
</script>

