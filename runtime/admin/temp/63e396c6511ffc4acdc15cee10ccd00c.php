<?php /*a:5:{s:48:"E:\WWW\tp6dedecms\app\admin\view\tool\index.html";i:1636455280;s:5:"param";i:0;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1636280202;s:50:"E:\WWW\tp6dedecms\app\admin\view\public\table.html";i:1636281698;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1636293469;}*/ ?>
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

<div class="layui-row progress">
   <div class="layui-progress" lay-showPercent="true" lay-filter="progress">
        <div class="layui-progress-bar layui-bg-red" lay-percent="0/0"></div>
    </div>
 </div>
<!--内容替换-->

<form class="layui-form replaceContent" action="" style='margin-left:15px;'> 
    <div class="layui-form-item"> 
        <textarea name="oldContent" placeholder="请输入原来内容" class="layui-textarea"></textarea> 
    </div> 
    <div class="layui-form-item"> 
        <textarea name="newsContent" placeholder="请输入新内容" class="layui-textarea"></textarea> 
    </div>
    <div class="layui-form-item"> 
        <div class="layui-input-block"> 
            <button class="layui-btn layui-btn-sm" lay-submit="" lay-filter="submit">保存</button>
            <button type="reset" class="layui-btn layui-btn-primary  layui-btn-sm">重置</button> 
     </div> 
    </div> 
</form>
<style>
    .replaceContent{display: none}
    .progress{
        width: 100%;
        position: fixed;
        left: 0;
        bottom: 35px;
        display: none;
        z-index: 999;
    }
</style>
 
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
<script type="text/html" id="tool">
  <div class="layui-btn-container">
    <button class="layui-btn layui-btn-sm layui-btn-normal" lay-event="replaceTag">一键换标签</button>
    <button class="layui-btn layui-btn-sm" lay-event="replaceContent">一键换内容</button>
    <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="delAll">删除选中</button>
  </div>
</script>
<script>
    layui.use(['table','element','jquery','form','tableTool'], function(){
      var table = layui.table
      ,element = layui.element
      ,form = layui.form
      ,tableTool = layui.tableTool
      ,$ = layui.jquery;
        //第一个实例
        var tableFliename = table.render({
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
            ,{field: 'filename', title: '文件名称', width:350,sort: true,align:'center',templet:tableTool.templet.title}
            ,{field: '', title: '操作', width:150,align:'center',templet:tableTool.templet.operate}
          ]]
        });
        tableTool.events.operate();
        table.on('toolbar(list)', function(obj){
            var checkStatus = table.checkStatus(obj.config.id);
            if(checkStatus.data.length == 0){
                layer.msg('没有选择任何文件!!!');
                return false;
            }
            if(obj.event === 'replaceContent'){
               $('.progress').show();  
                var len = checkStatus.data.length;
                layer.open({
                    title:'内容替换',
                    type: 1,
                    area: ['420px', '350px'], //宽高
                    content: $('.replaceContent'),
                    end:function(){
                        $(".progress").hide();
                        element.progress('progress',0);
                    }
                 });
                form.on('submit(submit)', function(formData){
                    for(var i = 0;i<len;i++){
                        data = checkStatus.data[i];
                        data.oldContent = formData.field.oldContent;;
                        data.newsContent= formData.field.newsContent;
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
                    return false;
                });
             }else if(obj.event === 'replaceTag'){
                $('.progress').show();
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
             }else if(obj.event === 'delAll'){
                 layer.confirm('真的删除么', function(index){
                    var len = checkStatus.data.length,data;
                    $('.progress').show();
                    for(var i = 0;i<len;i++){
                       data =checkStatus.data[i]
                       ,data.page = i+1
                       ,data.count = len;
                       $.post('<?php echo url("tool/del"); ?>',data,function(res){
                           if(res.code == 0){
                               layer.close(index);
                               element.progress('progress',res.progress);
                               element.init();
                           }
                           if(data.count == res.page) tableFliename.reload();
                       })
                       
                   }
                 })
                 return false;
             }
         })
        
    });
    
</script>