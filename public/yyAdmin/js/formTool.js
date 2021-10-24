layui.define(["element", "layer",'table','form'], function (exports) {
    var $ = jQuery = layui.jquery;
    var form = layui.form;
    var table = layui.table;
    var layer = layui.layer;
    var formTool = {
        uploads:function(url){
            var url = uploadUrl || url;
            var uploadList = document.querySelectorAll("[lay-filter=\"upload\"]");
            if (uploadList.length > 0) {
                $.each(uploadList, function(i, v) {
                    var _parent = $(this).parents('.layui-upload')
                    var input = _parent.find('input[type="text"]');
                    var uploadInst = layui.upload.render({
                        elem: this //绑定元素
                        ,url: url //上传接口
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
        },
        setValue:function(elem = '',data = []){
            var elem = elem || 'list',
            data = formData || data;
            if(data){
                form.val(elem,data);//赋值
           }
        },
        events:{
            /**
             * //监听提交
             * @param {type} url
             * @returns {undefined}
             */
            submit:function(submitUrl){
                var url = submitUrl||url;
                form.on('submit(submit)', function(obj){
                  var data =obj.field;
                  if(!data.file) delete data.file;
                  console.log(data);
                  $.post(url,data,function(res){
                      layer.msg(res.msg,{time:600},function(){
                            parent.layui.table.reload('list');
                            var index = parent.layer.getFrameIndex(window.name);  
                            parent.layer.close(index);
                      })
                  })
                  return false;
                });
            },
        }
    }
    exports('formTool', formTool);
});