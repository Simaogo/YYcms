<?php /*a:4:{s:51:"E:\WWW\tp6dedecms\app\admin\view\arctype\index.html";i:1634791219;s:5:"param";i:0;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1634202730;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1634222788;}*/ ?>
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

<div class="layui-row" style="margin-bottom: 50px;">
  <div class="layui-col-md12">
    <div class="layui-card">
      <div class="layui-card-header">栏目管理</div>
      <div class="layui-card-body">
          <table class="layui-table layui-form" id="list" lay-filter="list"></table>
      </div>
    </div>
  </div>
</div>

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

<script>
    
   layui.use(['tableTreeDj','table'], function() {
        let tableTree = layui.tableTreeDj
            ,table    = layui.table
            ,$ = layui.$;

        // 分页配置
        const page = {
            elem: 'page'
            , layout: ['prev', 'page', 'next', 'last','skip'] //自定义分页布局
            , groups: 5 //只显示 5 个连续页码
            , prev: '上一页'
            , next: '下一页'
            , first: 1 //不显示首页
        };

        // 字段配置
        const cols = [[
            {field:'id', title:'ID',width:80}
            ,{field:'typename', title:'名称',sort:true,width:'20%'}
            ,{field:'reid', title:'上级ID',width:100}
            ,{field:'', width:"20%", title: '操作',templet:'#operate'}
           
        ]];
        // 表格配置
        const objTable = {
            elem: '#list'
            ,toolbar: '#toolbar' 
            ,defaultToolbar: ['filter', 'exports', 'print', { 
              title: '提示'
              ,layEvent: 'LAYTABLE_TIPS'
              ,icon: 'layui-icon-tips'
            }]
            ,url: url
            ,page:false
            ,limit: 30
            ,cols: cols
            ,id: 'list'
            ,done:function(res, curr, count) {

            }
            ,parseData:function(res) {
                return {
                    "code": res.code, //解析接口状态
                    "msg": res.msg, //解析提示文本
                    "count": res.count, //解析数据长度
                    "data": res.data //解析数据列表
                };
            }
            ,loading:true
        }

        const config = {
            showCache: true // 开启展开缓存
            , sort: 'asc'
            , title: 'typename'
           , keyPid: "reid" // 上级ID
            , defaultShow: true
            , showByPidCallback: (idArr) => {
                //console.log('idArr', idArr);
            }
            , hideByPidCallback: (idArr) => {
                //console.log('idArr', idArr);
            }
        }
        // tableTree 渲染表格
        tableTree.render(objTable, config);
         //监听行工具事件

        $('#show').click(() => {
            tableTree.showAll(config);
        });
        $('#hide').click(() => {
            tableTree.hideAll(config);
        });

        $('#showSn').click(() => {
            const run = tableTree.getRun();
            const dataIndex = run.dataIndex;
            for(let id in dataIndex) {
                let has = true;
                let sn = id;
                let idNow = id;
                while(has) {
                    if(!!run.childParent[idNow]) {
                        let pid = run.childParent[idNow];
                        sn = pid + " - " + sn;
                        idNow = pid
                    } else {
                        break;
                    }
                }
                $("[lay-id='"+ objTable.id +"'] table tr[data-index='"+ dataIndex[id] +"'] td[data-field="+ "sn" +"]").children("div").html(sn);
            }
        });
        $('#getData').click(() => {
            const data = tableTree.getDataOri();
            console.log(data);
        });
        $('#reload').click(() => {
            /*
            if(objTable.url === './getData0.json') {
                objTable.url = './getData.json';
            } else {
                objTable.url = './getData0.json';
            }

             */
            objTable.where = {key:"val"}
            tableTree.reload(objTable, 'list');
        });

    });
    
</script>

