<?php /*a:4:{s:48:"E:\WWW\tp6dedecms\app\admin\view\tool\index.html";i:1634310823;s:5:"param";i:0;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1634202730;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1635159586;}*/ ?>
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
        bottom: 44px;
        display: none;
        z-index: 999;
    }
</style>
 
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
<script type="text/html" id="tool">
  <div class="layui-btn-container">
    <button class="layui-btn layui-btn-sm" lay-event="replaceTag">一键换标签</button>
    <button class="layui-btn layui-btn-sm" lay-event="replaceContent">一键换内容</button>
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
    layui.use(['table','element','jquery'], function(){
      var table = layui.table
      ,element = layui.element
      ,$ = layui.jquery;
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
         table.on('toolbar(list)', function(obj){
            var checkStatus = table.checkStatus(obj.config.id);
            if(checkStatus.data.length == 0){
                layer.msg('没有选择任何文件!!!');
                return false;
            }
            $('.progress').show();
             if(obj.event === 'replaceContent'){
                var len = checkStatus.data.length;
                layer.prompt({title: '输入原来内容，并确认', formType: 2}, function(oldContent, index){
                    layer.close(index);
                    layer.prompt({title: '输入新的内容，并确认', formType: 2}, function(newsContent, index){
                        layer.close(index);
                        for(var i = 0;i<len;i++){
                              data =checkStatus.data[i];
                              data.oldContent = oldContent;
                              data.newsContent= newsContent;
                              data.page = i+1;
                              data.count = len;
                              $.post('<?php echo url("tool/replaceContent"); ?>',data,function(res){
                                  if(res.code == 0){
                                      element.progress('progress',res.progress);
                                      element.init();
                                      layer.msg(res.msg);
                                  }
                              })
                         }
                    });
                });
             }else if(obj.event === 'replaceTag'){
                var len = checkStatus.data.length,data;
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
             }
         })
    });
    
</script>