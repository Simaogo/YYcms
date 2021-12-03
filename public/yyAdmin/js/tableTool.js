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
            title:function(d){
                 var field = d.LAY_COL.field,
                 html ='<a  href="javascript:;" lay-event="edit" >'+d[field]+'</a>';
                return html;
            },
            switch: function (d) {
                var config = d.LAY_COL,
                field = config.field;
                var checked = config['checked']||0;
                checked = d[field] ==  checked ? 'checked = checked':'';
                var html ='<input type="checkbox" name="'+d.LAY_COL.field+'" lay-skin="switch" lay-filter="switch" lay-text="开启|关闭" ' + checked + ' lay-id="'+ d.id+'">';
                return html;
            },
            operate: function (d) {
               var config = d.LAY_COL,
               html = '';
               if(config.operate){
                   var operate = config.operate,
                   len = operate.length;
                    for (var i = 0; i<len; i++){
                         if(operate[i] =='link'){ //配置link链接
                            html = html+ '<a class="layui-btn layui-btn-xs" lay-event="link" target="_blank" href="'+ config.link + d.id+'"><i class="layui-icon layui-icon layui-icon-link"></i></a>' ;
                         }
                         if(operate[i] =='table'){ //数据表格
                            html = html+ '<a class="layui-btn layui-btn-xs layui-bg-blue" lay-event="table" lay-url="'+config.url+'"><i class="layui-icon layui-icon layui-icon-group"></i></a>' ;
                         }
                    }  
                }
                html = html+'<a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon layui-icon-edit"></i></a>\n\
                       <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i></a>';
                return html;
            },
            images:function(d){
                var field = d.LAY_COL.field,
                src = d[field] || yyadminPath +'/images/image.gif',
                html = '<img src="'+ src +'" style="height:20px;cursor: pointer;" lay-event="images" lay-url="">';
                return html;
            },
           ispart: function(d){
                var ispart;
                if(d.ispart == 0){
                    ispart = '列表';
                }else if(d.ispart == 1){
                    ispart = '封面';
                }else{
                    ispart = '跳转';
                }
                return ispart;
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
            //返回当前和选择ids
//            childrenIds:function(data){
//               var strIds = data['id'];
//                var childrens = data['children'];
//               if(childrens){
//                    var len = childrens.length;
//                    for(var i = 0; i < len; i++){  
//                        strIds = strIds + ',' + childrens[i]["id"];
//                        if(childrens[i]['children']) {
//                            strIds = strIds + this.childrenIds(childrens[i]['children']);
//                        }
//
//                    }
//               }
//               return strIds;
//            },
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
                          var id = data.id||data.aid||data.rank||data.diyid;
                          var title = data.filename ? '编辑 ' + data.filename:'编辑';
                          var filename = data.filename ? '&filename='+ data.filename:'';
                          layer.open({
                           type: 2,
                           title: title,
                           shadeClose: true,
                           shade: 0.2,
                           maxmin: true, //开启最大化最小化按钮
                           area: ['85%', '85%'],
                           content: addEditUrl +'?id='+ id + filename //兼容filename
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
                    }else if(obj.event === 'table'){
                        var id = data.id||data.aid||data.rank||data.diyid;
                        var toUrl = $(this).attr('lay-url');
                          var title = '列表';
                          var filename = data.filename ? '&filename='+ data.filename:'';
                          layer.open({
                           type: 2,
                           title: title,
                           shadeClose: true,
                           shade: 0.2,
                           maxmin: true, //开启最大化最小化按钮
                           area: ['85%', '85%'],
                           content: toUrl+'?id='+id //
                         });
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
                          case 'delAll':
                            var data = checkStatus.data;
                            var len = data.length;
                            var ids = [];
                            for(var i = 0; i < len; i++){
                                ids.push(data[i].id);
                            }
                            layer.confirm('确定删除选中？', function(index){
                               $.post(delAllUrl,{ids:ids},function(res,index){
                                   layer.msg(res.msg,{time:350},function(){
                                       layer.close(index);
                                       window.location.reload();
                                   })
                               })
                               return false;
                            })

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