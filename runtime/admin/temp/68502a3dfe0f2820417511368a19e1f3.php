<?php /*a:4:{s:50:"E:\WWW\tp6dedecms\app\admin\view\config\index.html";i:1634994156;s:5:"param";i:0;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1634202730;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1635159586;}*/ ?>
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
<div class="layui-row" style="padding: 15px 0 50px 0">
    <div class="layui-col-md12">
        <div class="layui-tab" lay-filter="config">
          <ul class="layui-tab-title">
            <?php if(is_array($groupList) || $groupList instanceof \think\Collection || $groupList instanceof \think\Paginator): $i = 0; $__LIST__ = $groupList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>  
            <li <?php if($key==0): ?>class="layui-this"<?php endif; ?> lay-id="<?php echo htmlentities($key); ?>"><?php echo htmlentities($vo); ?></li>
           <?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
          <div class="layui-tab-content"> 
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?>
            <div class="layui-tab-item <?php if($key==0): ?> layui-show <?php endif; ?>">
               <?php if(is_array($group) || $group instanceof \think\Collection || $group instanceof \think\Paginator): $i = 0; $__LIST__ = $group;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;switch($vo['type']): case "string": ?>
                        <div class="layui-form-item">
                            <label class="layui-form-label"><?php echo htmlentities($vo['info']); ?></label>
                            <div class="layui-input-block">
                              <input type="text" name="<?php echo htmlentities($vo['varname']); ?>"  autocomplete="off" placeholder="请输入<?php echo htmlentities($vo['info']); ?>" class="layui-input" value="<?php echo htmlentities($vo['value']); ?>">
                            </div>
                        </div>
                    <?php break; case "number": ?>
                        <div class="layui-form-item">
                            <label class="layui-form-label"><?php echo htmlentities($vo['info']); ?></label>
                            <div class="layui-input-inline">
                              <input type="text" name="<?php echo htmlentities($vo['varname']); ?>"  autocomplete="off" placeholder="请输入<?php echo htmlentities($vo['info']); ?>" class="layui-input" value="<?php echo htmlentities($vo['value']); ?>">
                            </div>
                        </div>
                    <?php break; case "bool": ?>
                        <div class="layui-form-item">
                            <label class="layui-form-label"><?php echo htmlentities($vo['info']); ?></label>
                            <div class="layui-input-block">
                               <input type="radio" name="<?php echo htmlentities($vo['varname']); ?>" value="Y" title="是" <?php if($vo['value']=='Y'): ?>checked=""<?php endif; ?>>
                               <input type="radio" name="<?php echo htmlentities($vo['varname']); ?>" value="N" title="否" <?php if($vo['value']=='N'): ?>checked=""<?php endif; ?>>
                            </div>
                        </div>
                    <?php break; case "bstring": ?>
                        <div class="layui-form-item">
                            <label class="layui-form-label"><?php echo htmlentities($vo['info']); ?></label>
                            <div class="layui-input-block">
                              <textarea placeholder="请输入<?php echo htmlentities($vo['info']); ?>" class="layui-textarea" name="<?php echo htmlentities($vo['varname']); ?>"><?php echo htmlentities($vo['value']); ?></textarea>
                            </div>
                        </div>
                    <?php break; default: ?>
               <?php endswitch; ?>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            
             <?php endforeach; endif; else: echo "" ;endif; ?>
          </div>
        </div>
    </div>
</div> 
  <div class="layui-form-item layui-flex layui-submit" style="">
    <button class="layui-btn" lay-submit="" lay-filter="submit" style="width:150px;margin: 0 auto;">提交保存</button>
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
      formTool.events.submit();
    });
</script>