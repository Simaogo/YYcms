<?php /*a:4:{s:49:"E:\WWW\tp6dedecms\app\admin\view\arclist\add.html";i:1634993888;s:5:"param";s:44:"a:2:{s:2:"id";s:1:"0";s:6:"typeid";s:1:"0";}";s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1634202730;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1634992668;}*/ ?>
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

<script type="text/javascript" src="/yyAdmin/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/yyAdmin/plugins/ueditor/ueditor.all.js"></script>
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
                           <option value="<?php echo htmlentities($vo['id']); ?>" <?php if($channeltype!==$vo['channeltype']): ?>  disabled="disabled" <?php endif; if($typeid==$vo['id']): ?> selected <?php endif; ?>> 
                                   <?php echo htmlentities($vo['lefthtml']); ?> <?php echo htmlentities($vo['typename']); ?></option>
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
                      <input type="checkbox" name="flag[]" lay-skin="primary" title="跳转" value="j" lay-filter="redirecturl">
                    </div>
                    <div class="redirecturl layui-hide layui-col-md5"><input type="text" name="redirecturl" lay-skin="primary"  value="" placeholder="请输入跳转网址,必须带上(http://或者https:// )"class="layui-input"></div>
                 </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                      <label class="layui-form-label">TAG标签</label>
                      <div class="layui-input-inline">
                        <input type="tel" name="tags" lay-verify="" autocomplete="off" class="layui-input">
                      </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">排序</label>
                        <div class="layui-input-inline">
                            <input type="text" name="weight" lay-verify="" autocomplete="off" class="layui-input" value="50">
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
                <?php if($channeltype==2): ?>
                 <div class="layui-form-item">
                    <label class="layui-form-label">图集</label>
                     <div class="layui-input-block">
                        <input type="hidden" name="imgurls" class="multiple_show_img" value="">
                        <button type="button" class="layui-btn layui-btn-sm" id="multiple_img_upload">图集上传</button>
                        <div class="layui-upload" lay-filter="images">
                            <div class="layui-upload-list" id="div-slide_show">
                                <blockquote class="layui-elem-quote layui-quote-nm" style="height: 120px;">
                                    <ul class="layui-flex"></ul>
                                </blockquote>
                            </div>   
                         </div>
                     </div>
                </div>
                <?php endif; ?>
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
                        <option value="0" selected>开启</option>
                        <option value="1">关闭</option>
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
             <!---自定义字段start-->
            <?php if(isset($fieldset)): ?>
             <div class="layui-tab-item">
                <?php if(is_array($fieldset) || $fieldset instanceof \think\Collection || $fieldset instanceof \think\Paginator): $i = 0; $__LIST__ = $fieldset;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['name']!=='body'): switch($vo['type']): case "imgfile": ?>
                            <div class="layui-form-item layui-upload">
                                <label class="layui-form-label"><?php echo htmlentities($vo['itemname']); ?></label>
                                <div class="layui-input-inline">
                                    <input type="text" name="<?php echo htmlentities($vo['name']); ?>"  placeholder="请输入<?php echo htmlentities($vo['itemname']); ?>" autocomplete="off" class="layui-input" value="<?php echo htmlentities($vo['default']); ?>">
                                </div>
                                <div class="layui-word-aux ">
                                    <button type="button" class="layui-btn layui-btn-sm" id="<?php echo htmlentities($vo['name']); ?>" lay-filter="upload">
                                        <i class="layui-icon">&#xe67c;</i>上传
                                   </button>
                                </div>
                            </div>
                        <?php break; case "htmltext": ?>
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">内容</label>
                            <div class="layui-input-block">
                              <script id="<?php echo htmlentities($vo['name']); ?>" name="<?php echo htmlentities($vo['name']); ?>" type="text/plain" style="width:1024px;height:350px;"></script>
                              <script type="text/javascript">
                                    var ue = UE.getEditor('<?php echo htmlentities($vo['name']); ?>');
                                    ue.ready(function() {
                                    //设置编辑器的内容
                                    ue.setContent(formData["<?php echo htmlentities($vo['name']); ?>"]);
                                    //获取html内容，返回: <p>hello</p>
                                    var html = ue.getContent();
                                    //获取纯文本内容，返回: hello
                                    var txt = ue.getContentTxt();
                                });
                                </script>
                            </div>
                        </div>
                        <?php break; default: ?>
                        <div class="layui-form-item">
                            <label class="layui-form-label"><?php echo htmlentities($vo['itemname']); ?></label>
                            <div class="layui-input-block">
                              <input type="text" name="<?php echo htmlentities($vo['name']); ?>" placeholder="请输入<?php echo htmlentities($vo['itemname']); ?>" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    <?php endswitch; ?>
                    <?php endif; ?>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <?php endif; ?>
            
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
<script type="text/javascript">
    var ue = UE.getEditor('container');
    ue.ready(function() {
    //设置编辑器的内容
    ue.setContent(formData.body);
});
</script>
<script>
    layui.use(['form', 'laydate','upload','util','formTool'], function(){
      var form = layui.form
      ,layer = layui.layer
      ,upload = layui.upload
      ,$ = layui.jquery
      ,util = layui.util
      ,formTool = layui.formTool
      ,laydate = layui.laydate;
       laydate.render({
            elem: '#pubdate'
            ,type: 'datetime'
       });
       if(formData){
            //flag 选中
            var flag = formData.flag;
            $('input[name="flag[]"]').each(function(index){
               var flagVal = $(this).val();
                if(flag.includes(flagVal)){
                    if(flagVal == 'j'&& formData.redirecturl){
                        $('.redirecturl').removeClass('layui-hide');
                    }
                    $(this).attr('checked','checked');
                }
                form.render();
            })
       }
       //缩略图
       upload.render({
          elem: '#litpic'
          ,url: '<?php echo url("ajax/uploads"); ?>'
          ,done: function(res){
            layer.msg('上传成功');
            layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src', res.url);
            layui.$('input[name="litpic"]').val(res.url);
          }
        });
        //缩略图赋值
        if(formData.litpic){
            layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src', formData.litpic);
        }
       //图集上传
        upload.render({
          elem: '#multiple_img_upload'
          ,url: '<?php echo url("ajax/uploads"); ?>'
          ,multiple: true
          ,before:function(imgs){
              
          }
          ,done: function(res){
                layer.msg('上传成功');
                var imgurlsObj =$('input[name="imgurls"]');
                var imgsUrl = imgurlsObj.val();
                imgsUrl = imgsUrl?imgsUrl + ',' + res.url : res.url;
                imgurlsObj.val(imgsUrl)
                $('#div-slide_show ul').append('<li><img src="'+res.url+'" style="height:120px;"><i class="layui-icon layui-icon-close" lay-event="upfileDelete" data-fileurl="'+res.url+'"></i></li>');
          }
        });
        $(document.body).on('click','.layui-upload li',function(){
            $(this).addClass('thisClass').siblings().removeClass('thisClass');
            $('input[name="litpic"]').val($(this).find('img').attr('src'));
            layer.msg('设为缩略图')
        })
        $(document.body).on('click','.layui-upload li i',function(){
             var that = $(this);
             layer.confirm('真的删除么', function(index){
                    that.parent('li').remove();
                    var fileUrl =that.attr('data-fileurl'),
                    imgurlsObj = $('input[name="imgurls"]'),
                    imgurls = imgurlsObj.val(),
                    urlStr='';
                    if(imgurls && imgurls.match(RegExp(/,/i))){
                        var imgsArr = imgurls.split(',');
                        var len = imgsArr.length;
                        for(var i = 0;i < len; i++){
                            console.log(fileUrl,imgsArr[i]);
                            if(imgsArr[i] != fileUrl){
                               urlStr = urlStr + imgsArr[i] + ',';
                            }
                        }
                        urlStr = urlStr.slice(0,urlStr.length-1);//删掉,
                    }
                    imgurlsObj.val(urlStr);
                    layer.close(index);
              })
             return false;
        })
        //图集赋值
        if(formData.imgurls){
            console.log(formData);
            var imgurls = (typeof formData.imgurls) =='object' ? formData.imgurls : formData.imgurls.split(',');
            var litpic = formData.litpic,thisClass;
            var len =imgurls.length,thisClass;
                for(var i = 0; i < len; i++){
                     thisClass = litpic == imgurls[i] ? 'class ="thisClass"' : '';
                     $('#div-slide_show ul').append('<li '+thisClass+'><img src="'+imgurls[i]+'"><i class="layui-icon layui-icon-close"  data-fileurl="'+imgurls[i]+'"></i></li>');
                }
        }
        //跳转网址
         form.on('checkbox(redirecturl)', function(obj){
            if(obj.elem.checked){　　　　　　//判断当前多选框是选中还是取消选中
                $('.redirecturl').removeClass('layui-hide');
            }else{
                $('.redirecturl').addClass('layui-hide');
            }
            return false;
          });
      formTool.setValue();    
      formTool.events.submit();    
    });
</script>