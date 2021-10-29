layui.define(["element", "layer",'table','form'], function (exports) {
    var $ = jQuery = layui.jquery;
    var form = layui.form;
    var table = layui.table;
    var layer = layui.layer;
    var tableTool = {
        render:function(config){
            table.render(config)
        },
        templet:{
            switch: function (d) {
                var field = d.LAY_COL.field,
                checked = d[field] == 0 ? 'checked = checked':'',
                html ='<input type="checkbox" name="'+d.LAY_COL.field+'" lay-skin="switch" lay-filter="switch" lay-text="开启|关闭" ' + checked + ' lay-id="'+ d.id+'">';
                return html;
            },
            operate: function (d) {
                var html ='<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>\n\
                           <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>\n\
                           <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                return html;
            },
            images:function(d){
                var field = d.LAY_COL.field,
                src = d[field] || yyadminPath +'/images/image.gif',
                html = '<img src="'+ src +'" style="height:20px;cursor: pointer;" lay-event="images" lay-url="">';
                return html;
            }
        },
        events:{
            /**
             * 行开关
             * @returns {undefined}
             */
            switch:function(){
                form.on('switch(switch)', function (obj) {
                    var checked = obj.elem.checked ? 0 : 1,
                    name = $(this).attr('name'),
                    id = $(this).attr('lay-id'),
                    data = {
                        name:name,
                        id:id,
                        value:checked
                    }
                    $.post(rowEditUrl,data,function(res){
                        layer.msg(res.msg);
                        return false;
                    })
                })
            },
            /**
             * 行内容编辑
             * @returns {undefined}
             */
            rowEdit:function(){
                table.on('edit(list)', function(obj){
                   var field = obj.field;
                   var data = {
                       name:field,
                       value:obj.data[field],
                       id:obj.data.id
                   }
                   $.post(rowEditUrl,data,function(res){
                        layer.msg(res.msg);
                        return false;
                    })
                })
            },
            images:function(){
                
              return false;
            },
            operate:function(){
                table.on('tool(list)', function(obj){
                    var data = obj.data;
                    if(obj.event === 'del'){
                            layer.confirm('真的删除么', function(index){
                               $.post(delUrl,data,function(res,index){
                                   if(res.code==0) layer.msg(res.msg)
                               })
                               obj.del();
                               layer.close(index);
                            })
                    } else if(obj.event === 'edit'){
                          var id = data.id||data.aid; 
                          layer.open({
                           type: 2,
                           title: '编辑',
                           shadeClose: true,
                           shade: 0.2,
                           maxmin: true, //开启最大化最小化按钮
                           area: ['85%', '85%'],
                           content: addEditUrl +'?id='+ id
                         });
                    }else if(obj.event === 'images'){
                        var list =  $(this).attr('src');
                       layer.photos({
                            photos: { "data": [{
                            "alt": '',
                            "pid": Math.random(),
                            "src": list,
                            "thumb": ''
                            }]
                            }
                            ,anim: 5 
                      });
                      return false;
                    }
                });
            },
            toolbar:function(){
               // var addEditUrl = url||addEditUrl;
             //头工具栏事件
                table.on('toolbar(list)', function(obj){
                  var checkStatus = table.checkStatus(obj.config.id);
                  var postUrl = $(this).attr('lay-url');
                    switch(obj.event){
                          case 'add':
                            layer.open({
                                type: 2,
                                title: '添加',
                                shadeClose: true,
                                shade: 0.2,
                                maxmin: true, //开启最大化最小化按钮
                                area: ['85%', '85%'],
                                content: addEditUrl
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
                        default:
                            layer.confirm('真的要操作？', function(index){
                               $.post(postUrl,data,function(res,index){
                                   layer.msg(res.msg)
                               })
                               layer.close(index);
                            })
                    };
                })
            },
        },
    }
    exports('tableTool', tableTool);
});