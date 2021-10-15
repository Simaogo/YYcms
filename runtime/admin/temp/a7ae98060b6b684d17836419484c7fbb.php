<?php /*a:3:{s:49:"E:\WWW\tp6dedecms\template\admin\arctype\add.html";i:1634203021;s:51:"E:\WWW\tp6dedecms\template\admin\public\header.html";i:1634202730;s:51:"E:\WWW\tp6dedecms\template\admin\public\footer.html";i:1634222788;}*/ ?>
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
        <div class="layui-tab">
          <ul class="layui-tab-title">
            <li class="layui-this">常规信息</li>
            <li>高级参数</li>
            <li>栏目内容</li>
          </ul>
          <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <div class="layui-form-item">
                    <div class="layui-inline">
                      <label class="layui-form-label">上级栏目</label>
                      <div class="layui-input-inline">
                        <select name="reid" lay-verify="required">
                          <option value="0">顶级栏目</option>
                          <?php if(is_array($arctypeList) || $arctypeList instanceof \think\Collection || $arctypeList instanceof \think\Paginator): $i = 0; $__LIST__ = $arctypeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                           <option value="<?php echo htmlentities($vo['id']); ?>"> <?php echo htmlentities($vo['lefthtml']); ?> <?php echo htmlentities($vo['typename']); ?></option>
                          <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                      </div>
                    </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">栏目名称</label>
                  <div class="layui-input-block">
                    <input type="text" name="typename" lay-verify="required" autocomplete="off" placeholder="请输入栏目名称" class="layui-input">
                  </div>
                </div>
<!--                <div class="layui-form-item">
                  <label class="layui-form-label">英文名称</label>
                  <div class="layui-input-block">
                    <input type="text" name="typenameen" autocomplete="off" placeholder="请输入栏目名称英文" class="layui-input">
                  </div>
                </div>-->
                <div class="layui-form-item">
                    <div class="layui-inline">
                      <label class="layui-form-label">内容模型</label>
                      <div class="layui-input-inline">
                        <select name="channeltype" lay-verify="required">
                         <?php if(is_array($channeltype) || $channeltype instanceof \think\Collection || $channeltype instanceof \think\Paginator): $i = 0; $__LIST__ = $channeltype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                           <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['typename']); ?></option>
                          <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                      </div>
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">栏目属性</label>
                    <div class="layui-input-block">
                      <input type="radio" name="ispart" lay-skin="primary" title="列表"  value="0">
                      <input type="radio" name="ispart" lay-skin="primary" title="封面" value="1">
                      <input type="radio" name="ispart" lay-skin="primary" title="跳转" value="2">
                    </div>
                 </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                      <label class="layui-form-label">是否隐藏</label>
                      <div class="layui-input-inline">
                            <input type="radio" name="ishidden" lay-skin="primary" title="启用" value="0" checked>
                            <input type="radio" name="ishidden" lay-skin="primary" title="隐藏" value="1">
                      </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">浏览权限</label>
                        <div class="layui-input-inline">
                        <select name="corank" lay-verify="required" lay-search="">
<!--                          <option value="">直接选择或搜索选择</option>
                          <option value="1">layer</option>-->
                        </select>
                      </div>
                    </div>
                </div>
                 <div class="layui-form-item" pane="">
                    <label class="layui-form-label">栏目图片</label>
                    <div class="layui-upload-drag" id="typeimg">
                        <i class="layui-icon"></i>
                        <p>点击上传，或将文件拖拽到此处</p>
                        <div class="layui-hide" id="uploadDemoView">
                          <hr>
                          <img src="" alt="上传成功后渲染" style="max-width: 196px">
                        </div>
                    </div>
                </div>
            </div>
              
            <div class="layui-tab-item">
                <div class="layui-form-item">
                    <div class="layui-inline">
                      <label class="layui-form-label">封面模板</label>
                      <div class="layui-input-block">
                          <input type="text" name="tempindex" lay-verify="" autocomplete="off" class="layui-input" value="index_article.htm">
                      </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                      <label class="layui-form-label">列表模板</label>
                      <div class="layui-input-block">
                        <input type="text" name="templist" lay-verify="" autocomplete="off" class="layui-input" value="list_article.htm">
                      </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                      <label class="layui-form-label">文章模板</label>
                      <div class="layui-input-block">
                        <input type="text" name="temparticle" lay-verify="" autocomplete="off" class="layui-input" value="article_article.htm">
                      </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">SEO标题</label>
                    <div class="layui-input-block">
                      <input type="text" name="seotitle" lay-verify="" autocomplete="off" placeholder="请输入SEO标题" class="layui-input">
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
                 <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">栏目内容</label>
                    <div class="layui-input-block">
                      <script id="container" name="content" type="text/plain" style="width:1024px;height:500px;"></script>
                    </div>
                  </div>
             </div>
          </div>
       </div>
        <div class="layui-form-item layui-flex layui-submit" style="">
            <button class="layui-btn" lay-submit="" lay-filter="submit" style="width:150px;margin: 0 auto;">提交保存</button>
        </div>
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
    window.addEditUrl = window.location.href,
    window.url = window.location.href,         
    window.STATIC ='__STATIC__'
    window.ADDONS = '__ADDONS__'
    window.PLUGINS = '/static/plugins';
    //form公共提交
    layui.use(['form', 'jquery','table','element'], function(){
      var form = layui.form
      ,layer = layui.layer
      ,table = layui.table
      ,$ = layui.jquery;
       if(formData){
            layui.form.val('list',formData);//赋值
       }
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
    //上传
    var $ =layui.$;
    var uploadList = document.querySelectorAll("[lay-filter=\"upload\"]");
    if (uploadList.length > 0) {
        $.each(uploadList, function(i, v) {
            var _parent = $(this).parents('.layui-upload')
            var input = _parent.find('input[type="text"]');
            var uploadInst = layui.upload.render({
                elem: this //绑定元素
                ,url: '<?php echo url("ajax/uploads"); ?>' //上传接口
                ,done: function(res){
                  input.val(res.url);
                  layer.msg(res.msg)
                }
                ,error: function(){
                  //请求异常回调
               }
            })
        })
    }
    
    layui.config({
        base: "/yyAdmin/layui/lay/modules/"
    })
</script>
</body>
</html>
<script type="text/javascript" src="/yyAdmin/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/yyAdmin/plugins/ueditor/ueditor.all.js"></script>
<script type="text/javascript">
    var ue = UE.getEditor('container');
    ue.ready(function() {
    //设置编辑器的内容
    ue.setContent(formData.content);
    //获取html内容，返回: <p>hello</p>
    var html = ue.getContent();
    //获取纯文本内容，返回: hello
    var txt = ue.getContentTxt();
});
</script>
<script>
    layui.use(['form', 'layedit', 'laydate','upload'], function(){
      var form = layui.form
      ,layer = layui.layer
      ,layedit = layui.layedit
      ,upload = layui.upload
      ,$ = layui.jquery
      ,laydate = layui.laydate;

      //创建一个编辑器
      var editIndex = layedit.build('LAY_demo_editor');

      //自定义验证规则
      form.verify({
        title: function(value){
          if(value.length < 5){
            return '标题至少得5个字符啊';
          }
        }
        ,pass: [
          /^[\S]{6,12}$/
          ,'密码必须6到12位，且不能出现空格'
        ]
        ,content: function(value){
          layedit.sync(editIndex);
        }
      });

      //监听指定开关
      form.on('switch(switchTest)', function(data){
        layer.msg('开关checked：'+ (this.checked ? 'true' : 'false'), {
          offset: '6px'
        });
        layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
      });


      
      //表单取值
        layui.$('#LAY-component-form-getval').on('click', function(){
          var data = form.val('example');
          alert(JSON.stringify(data));
        });
       laydate.render({
            elem: '#pubdate'
            ,type: 'datetime'
       });
       //拖拽上传
        upload.render({
          elem: '#litpic'
          ,url: '<?php echo url("common/upload/image"); ?>' 
          ,done: function(res){
            layer.msg('上传成功');
            layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src', res.data.src);
          }
        });
    });
</script>