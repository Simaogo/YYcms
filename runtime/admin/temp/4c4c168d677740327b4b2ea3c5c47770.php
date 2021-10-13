<?php /*a:3:{s:50:"E:\WWW\tp6dedecms\template\admin\config\index.html";i:1633601717;s:51:"E:\WWW\tp6dedecms\template\admin\public\header.html";i:1633268996;s:51:"E:\WWW\tp6dedecms\template\admin\public\footer.html";i:1633853083;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>栏目管理</title>
  <link rel="stylesheet" href="/static/layui/css/layui.css">
  <link rel="stylesheet" href="/static/admin/css/common.css">
</head>
<body>

<form class="layui-form" action="" lay-filter="list">
<div class="layui-row" style="padding: 15px">
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
<script src="/static/layui/layui.js"></script>
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
    window.addEditUrl = window.location.href,
    window.url = window.location.href,         
    window.STATIC ='/static/admin'
    window.ADDONS = '__ADDONS__'
    window.PLUGINS = '/static/plugins';
    if(formData){
        layui.form.val('list',formData);//赋值
    }
    console.log(formData);
    //form公共提交
    layui.use(['form', 'jquery','table','element'], function(){
      var form = layui.form
      ,layer = layui.layer
      ,table = layui.table
      ,element = layui.element
      ,$ = layui.jquery;
      //监听提交
      form.on('submit(submit)', function(obj){
        var data =obj.field;
        $.post(url,data,function(res){
            layer.msg(res.msg,{time:600},function(){
                  parent.layui.table.reload('list');
                  var index = parent.layer.getFrameIndex(window.name);  
                  parent.layer.close(index);
            })
        })
        return false;
      });
        //监听行工具事件
       table.on('tool(list)', function(obj){
             var data = obj.data;
             if(obj.event === 'del'){
                layer.confirm('真的删除么', function(index){
                     $.post("<?php echo url(request()->controller().'/del'); ?>",data,function(res,index){
                         if(res.code==0) layer.msg(res.msg)
                     })
                     obj.del();
                     layer.close(index);
               })
             } else if(obj.event === 'edit'){
                layer.open({
                 type: 2,
                 title: '编辑',
                 shadeClose: true,
                 shade: 0.2,
                 maxmin: true, //开启最大化最小化按钮
                 area: ['85%', '85%'],
                 content: '<?php echo url(request()->controller()."/addEdit"); ?>?id='+data.id
               });
             }
         });
        //头工具栏事件
        table.on('toolbar(list)', function(obj){
          var checkStatus = table.checkStatus(obj.config.id);
          switch(obj.event){
            case 'add':
              layer.open({
                  type: 2,
                  title: '添加',
                  shadeClose: true,
                  shade: 0.2,
                  maxmin: true, //开启最大化最小化按钮
                  area: ['85%', '85%'],
                  content: '<?php echo url(request()->controller()."/addEdit"); ?>'
               });
            break; 
            break;
            case 'getCheckLength':
              var data = checkStatus.data;
              layer.msg('选中了：'+ data.length + ' 个');
            break;
            case 'isAll':
              layer.msg(checkStatus.isAll ? '全选': '未全选');
            break;

            //自定义头工具栏右侧图标 - 提示
            case 'LAYTABLE_TIPS':
              layer.alert('这是工具栏右侧自定义的一个图标按钮');
            break;
          };
        });

    });
    layui.config({
        base: '../../static/layui/model/' //目录
      })
</script>
</body>
</html>
<script>
layui.use('element', function(){
  var $ = layui.jquery
  ,element = layui.element; //Tab的切换功能，切换事件监听等，需要依赖element模块
  
  $('.site-demo-active').on('click', function(){
    var othis = $(this), type = othis.data('type');
    active[type] ? active[type].call(this, othis) : '';
  });

  //Hash地址的定位
  var layid = location.hash.replace(/^?gid=0#id=/, '');
  element.tabChange('config', layid);
  
  element.on('tab(config)', function(elem){
    location.hash = '?id='+ $(this).attr('lay-id');
  });
  
});
</script>