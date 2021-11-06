<?php /*a:4:{s:56:"E:\WWW\tp6dedecms\app\admin\view\auth_rule\add_edit.html";i:1636175804;s:5:"param";s:23:"a:1:{s:2:"id";s:1:"1";}";s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1635936494;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1635936494;}*/ ?>
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
              <label class="layui-form-label">权限上级</label>
              <div class="layui-input-inline">
                <select name="reid" lay-verify="required">
                  <option value="0">顶级</option>
                  <?php if(is_array($authRuleList) || $authRuleList instanceof \think\Collection || $authRuleList instanceof \think\Paginator): $i = 0; $__LIST__ = $authRuleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                   <option value="<?php echo htmlentities($vo['id']); ?>"> <?php echo $vo['lefthtml']; ?> <?php echo htmlentities($vo['title']); ?></option>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
              </div>
            </div>
        </div>
        <div class="layui-form-item">
     
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
              <input type="text" name="title" lay-verify="required" autocomplete="off" placeholder="名称" class="layui-input">
            </div>
        
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
              <label class="layui-form-label">Url</label>
              <div class="layui-input-inline">
                    <input type="text" name="href" lay-verify="required" autocomplete="off" placeholder="控制器/方法" class="layui-input">
              </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
              <label class="layui-form-label">图标</label>
              <div class="layui-input-inline">
                    <input type="text" name="icon" lay-verify="required" autocomplete="off" placeholder="图标" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux"><a href="https://remixicon.com/" target="_blank">图标地址https://remixicon.com</a></div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
              <label class="layui-form-label">是否菜单</label>
              <div class="layui-input-inline">
                    <input type="radio" name="menu_status" lay-skin="primary" title="启用" value="1" checked>
                    <input type="radio" name="menu_status" lay-skin="primary" title="隐藏" value="0">
              </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
              <label class="layui-form-label">状态</label>
              <div class="layui-input-inline">
                    <input type="radio" name="status" lay-skin="primary" title="启用" value="1" checked>
                    <input type="radio" name="status" lay-skin="primary" title="关闭" value="0">
              </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
              <label class="layui-form-label">排序</label>
              <div class="layui-input-inline">
                    <input type="text" name="sort" lay-skin="primary" title="排序" value="1" class="layui-input">
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
    layui.use(['form','formTool'], function(){
      var form = layui.form
      ,formTool = layui.formTool
      ,$ = layui.jquery
      ,laydate = layui.laydate;
       laydate.render({
            elem: '#pubdate'
            ,type: 'datetime'
       });
        //跳转网址
        form.on('radio(redirecturl)', function(obj){
            if(obj.value == 2){　　　　　　//判断当前多选框是选中还是取消选中
                $('.redirecturl').removeClass('layui-hide');
            }else{
                $('.redirecturl').addClass('layui-hide');
            }
            return false;
          });
       formTool.events.submit();//form提交
       formTool.setValue();
       formTool.uploads();
    });
</script>