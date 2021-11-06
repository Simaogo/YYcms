<?php /*a:4:{s:52:"E:\WWW\tp6dedecms\app\admin\view\admin\add_edit.html";i:1635936494;s:5:"param";s:23:"a:1:{s:2:"id";s:1:"1";}";s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1635936494;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1636185197;}*/ ?>
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
         <div class="layui-inline">
           <label class="layui-form-label">用户名</label>
           <div class="layui-input-inline">
                 <input type="text" name="userid" lay-verify="" autocomplete="off" class="layui-input">
           </div>
         </div>
         <div class="layui-inline">
           <label class="layui-form-label">级别等级</label>
           <div class="layui-input-inline">
                 <select name="usertype" lay-filter="required">
                     <?php if(is_array($usertype) || $usertype instanceof \think\Collection || $usertype instanceof \think\Paginator): $i = 0; $__LIST__ = $usertype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                     <option value="<?php echo htmlentities($vo['rank']); ?>"><?php echo htmlentities($vo['typename']); ?></option>
                     <?php endforeach; endif; else: echo "" ;endif; ?>
                  </select>
           </div>
         </div>
   </div>
    <div class="layui-form-item">
     <div class="layui-inline">
       <label class="layui-form-label">密码</label>
       <div class="layui-input-inline">
             <input type="password" name="pwd" lay-verify="" autocomplete="off" class="layui-input">
       </div>
     </div>
     <div class="layui-inline">
       <label class="layui-form-label">重复密码</label>
       <div class="layui-input-inline">
         <input type="password" name="pwdreplace"  autocomplete="off" class="layui-input">
       </div>
     </div>
   </div>
   <div class="layui-form-item">
     <div class="layui-inline">
       <label class="layui-form-label">姓名</label>
       <div class="layui-input-inline">
             <input type="text" name="uname" lay-verify="" autocomplete="off" class="layui-input">
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
    layui.use('formTool', function(){
       var formTool = layui.formTool;
       formTool.setValue();
       formTool.events.submit();
    })
</script>