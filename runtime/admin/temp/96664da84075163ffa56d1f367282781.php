<?php /*a:4:{s:51:"E:\WWW\tp6dedecms\app\admin\view\tool\add_edit.html";i:1636453458;s:5:"param";s:54:"a:2:{s:2:"id";s:1:"1";s:8:"filename";s:9:"_left.htm";}";s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1636280202;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1636293469;}*/ ?>
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

 <link rel="stylesheet" href="/yyAdmin/plugins/codemirror-5.63.3/lib/codemirror.css">
 <link rel="stylesheet" href="/yyAdmin/plugins/codemirror-5.63.3/theme/monokai.css">
 <script src="/yyAdmin/plugins/codemirror-5.63.3/lib/codemirror.js"></script>
<script src="/yyAdmin/plugins/codemirror-5.63.3/addon/edit/matchbrackets.js"></script>
<script src="/yyAdmin/plugins/codemirror-5.63.3/addon/selection/active-line.js"></script>
<script src="/yyAdmin/plugins/codemirror-5.63.3/keymap/sublime.js"></script>
<script src="/yyAdmin/plugins/codemirror-5.63.3/mode/javascript/javascript.js"></script>
<script src="/yyAdmin/plugins/codemirror-5.63.3/mode/htmlembedded/htmlembedded.js"></script>
<style>
    .CodeMirror {
      overscroll-y: scroll !important;
      height: auto !important;
      min-height: 600px
    }
</style>
<form class="layui-form" action="" lay-filter="list" style="margin:0">
    <div class="layui-row">
        <div class="layui-block">
            <textarea type="text" id = "filecontent" name="filecontent" lay-verify="" autocomplete="off" class="layui-textarea" width="100%" style="display:none"><?php echo htmlentities($filecontent); ?></textarea>
        </div>
</div>
<div class="layui-flex layui-submit">
    <button class="layui-btn layui-btn-sm layui-submit-btn" lay-submit="" lay-filter="submit">保存</button>
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
   var extraKeys = {'Ctrl-Q': 'autocomplete','Ctrl-S':function(){
           var data = {filecontent:editor.getValue()}
          layui.$.post(url,data,function(res){
              layui.layer.msg(res.msg);
          });
          return false;
   }}
   var editor = CodeMirror.fromTextArea(document.getElementById("filecontent"), {
        mode: 'javascript', //设置编译器编程语言关联内容，需要引入mode/javascript/javascript.js
        lineNumbers: true, //显示行号
        smartIndent: true, //自动缩进是否开启
        indentUnit: 2, //缩进单位
        theme: 'monokai', //设置主题
        styleActiveLine: true, //设置光标所在行高亮，需要引入addon/selection/active-line.js
        keyMap: 'sublime', // 快捷键，default使用默认快捷键，除此之外包括emacs，sublime，vim快捷键，使用需引入工具,keymap/sublime.js
        extraKeys:extraKeys //设置快捷键
     });
    editor.save();
    layui.use(['formTool','jquery'], function(){
       var formTool = layui.formTool,
       $ = layui.jquery;
      formTool.events.submit();
    })
</script>