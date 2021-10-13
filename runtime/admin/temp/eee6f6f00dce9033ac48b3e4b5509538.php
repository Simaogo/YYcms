<?php /*a:3:{s:49:"E:\WWW\tp6dedecms\template\admin\arclist\add.html";i:1634036164;s:51:"E:\WWW\tp6dedecms\template\admin\public\header.html";i:1633268996;s:51:"E:\WWW\tp6dedecms\template\admin\public\footer.html";i:1633853083;}*/ ?>
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
    <div class="layui-row" style="padding: 15px;margin-bottom: 35px">
        <div class="layui-tab">
          <ul class="layui-tab-title">
            <li class="layui-this">常规信息</li>
            <li>高级参数</li>
            <?php if(isset($fieldset)): ?><li>自定义</li><?php endif; ?>
          </ul>
          <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <div class="layui-form-item">
                    <div class="layui-inline">
                      <label class="layui-form-label">栏目选择</label>
                      <div class="layui-input-inline">
                        <select name="typeid" lay-verify="required">
                           <option value=""> 请选择</option> 
                          <?php if(is_array($arctypeList) || $arctypeList instanceof \think\Collection || $arctypeList instanceof \think\Paginator): $i = 0; $__LIST__ = $arctypeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                           <option value="<?php echo htmlentities($vo['id']); ?>"> <?php echo htmlentities($vo['lefthtml']); ?> <?php echo htmlentities($vo['typename']); ?></option>
                          <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                      </div>
                    </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">标题</label>
                  <div class="layui-input-block">
                    <input type="text" name="title" lay-verify="required" autocomplete="off" placeholder="请输入标题" class="layui-input">
                  </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">自定义属性</label>
                    <div class="layui-input-block">
                      <input type="checkbox" name="flag[]" lay-skin="primary" title="头条" value="h">
                      <input type="checkbox" name="flag[]" lay-skin="primary" title="推荐" value="c">
                      <input type="checkbox" name="flag[]" lay-skin="primary" title="幻灯" value="f">
                      <input type="checkbox" name="flag[]" lay-skin="primary" title="特荐" value="a">
                      <input type="checkbox" name="flag[]" lay-skin="primary" title="滚动" value="s">
                      <input type="checkbox" name="flag[]" lay-skin="primary" title="加粗" value="b">
                      <input type="checkbox" name="flag[]" lay-skin="primary" title="图片" value="p">
                      <input type="checkbox" name="flag[]" lay-skin="primary" title="跳转" value="j">
                    </div>
                 </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                      <label class="layui-form-label">TAG标签</label>
                      <div class="layui-input-inline">
                        <input type="tel" name="tags" lay-verify="" autocomplete="off" class="layui-input">
                      </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">权重</label>
                        <div class="layui-input-inline">
                            <input type="text" name="weight" lay-verify="" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>
                 <div class="layui-form-item" pane="">
                    <label class="layui-form-label">缩略图</label>
                    <div class="layui-upload-drag" id="litpic">
                        <i class="layui-icon"></i>
                        <p>点击上传，或将文件拖拽到此处</p>
                        <div class="layui-hide" id="uploadDemoView">
                          <hr>
                          <img src="" alt="上传成功后渲染" style="max-width: 196px">
                           <input type="hidden" name="litpic" >
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                      <label class="layui-form-label">文章来源</label>
                      <div class="layui-input-inline">
                        <input type="text" name="source" lay-verify="" autocomplete="off" class="layui-input">
                      </div>
                    </div>
                    <div class="layui-inline">
                      <label class="layui-form-label">作者</label>
                      <div class="layui-input-inline">
                        <input type="text" name="writer" lay-verify="" autocomplete="off" class="layui-input">
                      </div>
                    </div>
                </div>
                 <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">内容</label>
                    <div class="layui-input-block">
                      <script id="container" name="body" type="text/plain" style="width:1024px;height:500px;"></script>
                    </div>
                  </div>
            </div>
            <div class="layui-tab-item">
            
                <div class="layui-form-item">
                    <div class="layui-inline">
                      <label class="layui-form-label">预览次数</label>
                      <div class="layui-input-inline">
                        <input type="text" name="click"  autocomplete="off" class="layui-input">
                      </div>
                    </div>
                    <div class="layui-inline">
                    <label class="layui-form-label">阅读权限</label>
                    <div class="layui-input-inline">
                      <select name="arcrank" lay-verify="" lay-search="">
                        <option value="">直接选择或搜索选择</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                      <label class="layui-form-label">更新时间：</label>
                      <div class="layui-input-inline">
                        <input type="text" name="pubdate" lay-verify="" autocomplete="off" class="layui-input" id="pubdate">
                      </div>
                    </div>
                    <div class="layui-inline">
                      <label class="layui-form-label">标题颜色</label>
                      <div class="layui-input-inline">
                        <input type="text" name="color" lay-verify="" autocomplete="off" class="layui-input">
                      </div>
                    </div>
                 </div>
                 <div class="layui-form-item">
                    <label class="layui-form-label">关键词</label>
                    <div class="layui-input-block">
                      <input type="text" name="keywords" lay-verify="" autocomplete="off" placeholder="请输入关键词" class="layui-input">
                    </div>
                 </div>
                  <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">描述</label>
                    <div class="layui-input-block">
                      <textarea placeholder="请输入描述" class="layui-textarea" name="description"></textarea>
                    </div>
                  </div>

             </div>
            <div class="layui-tab-item">
                
                <?php if(isset($fieldset)): ?>
                    <?php echo $fieldset; ?>
                <?php endif; ?>
            </div>
          </div>
       </div>
        <div class="layui-form-item layui-flex layui-submit" style="">
            <button class="layui-btn" lay-submit="" lay-filter="submit" style="width:150px;margin: 0 auto;">提交保存</button>
        </div>
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
<script type="text/javascript" src="/static/plugins/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/static/plugins/ueditor/ueditor.all.js"></script>
<script type="text/javascript">
    var ue = UE.getEditor('container');
    ue.ready(function() {
    //设置编辑器的内容
    ue.setContent(formData.body);
    //获取html内容，返回: <p>hello</p>
    var html = ue.getContent();
    //获取纯文本内容，返回: hello
    var txt = ue.getContentTxt();
});
</script>
<script>
    layui.use(['form', 'laydate','upload'], function(){
      var form = layui.form
      ,layer = layui.layer
      ,upload = layui.upload
      ,$ = layui.jquery
      ,laydate = layui.laydate;
       laydate.render({
            elem: '#pubdate'
            ,type: 'datetime'
       });
       if(formData){
            //flag 选中
            $('input[name="flag[]"]').each(function(index){
                var flag = formData.flag;
                if(flag.includes($(this).val())){
                    $(this).attr('checked','checked'); 
                }
                form.render();
            })
            layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src',formData.litpic);//缩略图
       }
       //拖拽上传
        upload.render({
          elem: '#litpic'
          ,url: '<?php echo url("common/upload/image"); ?>'
          ,done: function(res){
            layer.msg('上传成功');
            layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src', res.data.src);
             //console.log(layui.$('input[name="litpic"]'));
            layui.$('input[name="litpic"]').val(res.data.src);
          }
        });
    });
</script>