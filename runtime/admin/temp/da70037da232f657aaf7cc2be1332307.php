<?php /*a:4:{s:56:"E:\WWW\tp6dedecms\app\admin\view\admintype\add_edit.html";i:1636182215;s:5:"param";s:24:"a:1:{s:2:"id";s:2:"10";}";s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1635936494;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1635936494;}*/ ?>
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

<form class="layui-form" action="" lay-filter="list">
    <div class="layui-row layui-form-list">
        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                  <input type="text" name="typename" lay-verify="" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限管理</label>
            <div class="layui-input-block">
                   <table id="list" lay-filter="list"></table>
            </div>
        </div>
    </div>
    <div class="layui-flex layui-submit">
        <button class="layui-btn layui-btn-sm layui-submit-btn" lay-submit="" lay-filter="submit">提交</button>
    </div>  
</form>
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
    layui.use(['formTool','tableTool','tree','jquery'], function(){
       var formTool = layui.formTool
       ,tableTool = layui.tableTool
       ,$ = layui.jquery
       ,tree = layui.tree;
       var authRuleList = <?php echo json_encode($authRuleList); ?>;
       formTool.setValue();
       tree.render({
            elem: '#list'
            ,id: 'list'
            ,field:'purviews[]'
            ,showCheckbox:true
            ,data: authRuleList
          });
       formTool.events.submit();
    })
</script>