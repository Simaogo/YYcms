<?php /*a:4:{s:49:"E:\WWW\tp6dedecms\app\admin\view\arctype\add.html";i:1634989907;s:5:"param";s:23:"a:1:{s:2:"id";s:1:"1";}";s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1634202730;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1634992668;}*/ ?>
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
                </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">排序</label>
                    <div class="layui-input-inline">
                      <input type="text" name="sortrank" required=""  lay-vertype="tips" placeholder="请输入排序" autocomplete="off" class="layui-input" value="50">
                    </div>
                    <div class="layui-form-mid layui-word-aux">请输入排序</div>
                  </div>  

                 <div class="layui-form-item layui-upload">
                    <label class="layui-form-label">栏目图片</label>
                    <div class="layui-input-inline">
                        <input type="text" name="typeimg"  placeholder="请输入栏目图片" autocomplete="off" class="layui-input" value="">
                    </div>
                    <div class="layui-word-aux ">
                        <button type="button" class="layui-btn layui-btn-sm" id="typeimg" lay-filter="upload">
                            <i class="layui-icon">&#xe67c;</i>上传
                       </button>
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
    layui.use(['form','formTool'], function(){
      var form = layui.form
      ,formTool = layui.formTool
      ,$ = layui.jquery
      ,laydate = layui.laydate;
       laydate.render({
            elem: '#pubdate'
            ,type: 'datetime'
       });
       formTool.events.submit();//form提交
       formTool.setValue();
       formTool.uploads();
    });
</script>