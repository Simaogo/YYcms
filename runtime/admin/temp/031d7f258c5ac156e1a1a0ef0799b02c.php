<?php /*a:4:{s:52:"E:\WWW\tp6dedecms\app\admin\view\myppt\add_edit.html";i:1635423761;s:5:"param";s:23:"a:1:{s:2:"id";s:1:"1";}";s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1634202730;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1635159586;}*/ ?>
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
    <div class="layui-row" style="padding: 15px;margin-bottom: 35px">
    <div class="layui-form-item">
        <label class="layui-form-label">名称</label>
        <div class="layui-input-block">
              <input type="text" name="title" lay-verify="" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
     <div class="layui-inline">
        <label class="layui-form-label">分类</label>
        <div class="layui-input-inline">
              <select name="typeid" lay-filter="required">
                  <?php if(is_array($myppttype) || $myppttype instanceof \think\Collection || $myppttype instanceof \think\Paginator): $i = 0; $__LIST__ = $myppttype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                  <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['typename']); ?></option>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
               </select>
        </div>
      </div>
   </div>
    <div class="layui-form-item layui-upload">
        <label class="layui-form-label">图片</label>
        <div class="layui-input-inline">
            <input type="text" name="pic"  placeholder="请输入图片" autocomplete="off" class="layui-input" value="">
        </div>
        <div class="layui-word-aux ">
            <button type="button" class="layui-btn layui-btn-sm" id="pic" lay-filter="upload">
                <i class="layui-icon">&#xe67c;</i>上传
           </button>
        </div>
    </div>   
   <div class="layui-form-item">
       <label class="layui-form-label">链接</label>
       <div class="layui-input-block">
             <input type="text" name="url" lay-verify="" autocomplete="off" class="layui-input">
       </div>
   </div>    
   <div class="layui-form-item">
     <div class="layui-inline">
       <label class="layui-form-label">排序</label>
       <div class="layui-input-inline">
             <input type="text" name="orderid" lay-verify="" autocomplete="off" class="layui-input">
       </div>
     </div>
   </div>
</div>
<div class="layui-form-item layui-flex layui-submit">
    <button class="layui-btn" lay-submit="" lay-filter="submit" style="width:120px;margin: 0 auto;">提交</button>
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
    layui.use('formTool', function(){
       var formTool = layui.formTool;
       formTool.setValue();
       formTool.events.submit();
       formTool.uploads();
    })
</script>