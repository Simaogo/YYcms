<?php /*a:4:{s:52:"E:\WWW\tp6dedecms\app\admin\view\flink\add_edit.html";i:1635936494;s:5:"param";s:23:"a:1:{s:2:"id";s:1:"2";}";s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1636280202;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1636293469;}*/ ?>
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

<form class="layui-form" action="" lay-filter="list">
    <div class="layui-row layui-form-list">
        <div class="layui-form-item">
             <label class="layui-form-label">网站名称</label>
             <div class="layui-input-block">
                   <input type="text" name="webname" lay-verify="required" autocomplete="off" class="layui-input">
             </div>
         </div>
         <div class="layui-form-item">
           <label class="layui-form-label">级别等级</label>
           <div class="layui-input-inline">
                 <select name="typeid" lay-filter="required">
                     <?php if(is_array($flinktype) || $flinktype instanceof \think\Collection || $flinktype instanceof \think\Paginator): $i = 0; $__LIST__ = $flinktype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                     <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['typename']); ?></option>
                     <?php endforeach; endif; else: echo "" ;endif; ?>
                  </select>
           </div>
         </div>  
         <div class="layui-form-item">
             <label class="layui-form-label">网址</label>
             <div class="layui-input-block">
                   <input type="text" name="url" lay-verify="" autocomplete="off" class="layui-input">
             </div>
        </div>
       <div class="layui-form-item layui-upload">
           <label class="layui-form-label">图片</label>
           <div class="layui-input-inline">
                 <input type="text" name="logo" lay-verify="" autocomplete="off" class="layui-input">
           </div>
           <div class="layui-word-aux layui-upload">
                 <button type="button" class="layui-btn layui-btn-sm" id="<?php echo htmlentities($vo['name']); ?>" lay-filter="upload">
                     <i class="layui-icon">&#xe67c;</i>上传
                </button>
           </div>
       </div>
      <div class="layui-form-item">
         <label class="layui-form-label">排序</label>
         <div class="layui-input-inline">
           <input type="text" name="sortrank" lay-verify="" autocomplete="off" class="layui-input">
         </div>
       </div>
       <div class="layui-form-item">
         <div class="layui-inline">
           <label class="layui-form-label">备注</label>
           <div class="layui-input-inline">
                 <input type="text" name="msg" lay-verify="" autocomplete="off" class="layui-input">
           </div>
         </div>
         <div class="layui-inline">
           <label class="layui-form-label">邮件</label>
           <div class="layui-input-inline">
             <input type="text" name="email" lay-verify="" autocomplete="off" class="layui-input">
           </div>
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
    layui.use('formTool', function(){
       var formTool = layui.formTool;
       formTool.setValue();
       formTool.uploads();
       formTool.events.submit();
    })
</script>