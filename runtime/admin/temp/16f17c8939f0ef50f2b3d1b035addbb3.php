<?php /*a:4:{s:51:"E:\WWW\tp6dedecms\app\admin\view\arctype\index.html";i:1635936494;s:5:"param";i:0;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\header.html";i:1635936494;s:51:"E:\WWW\tp6dedecms\app\admin\view\public\footer.html";i:1636185197;}*/ ?>
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

<style>
    .layui-table-cell{cursor: pointer;}
</style>
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
    <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="delAll">删除</button>
  </div>
</script>
<script type="text/html" id="operate">
  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del" >删除</a>
</script>
<script>
    window.formData = <?php echo isset($formData)?(json_encode($formData)):'""'; ?>,
    window.url = window.location.href,//当前URL
    window.yyadminPath ='/yyAdmin'; 
    window.addEditUrl = '<?php echo url(request()->controller()."/addEdit"); ?>',
    window.rowEditUrl = '<?php echo url(request()->controller()."/rowEdit"); ?>',
    window.uploadUrl = '<?php echo url("ajax/uploads"); ?>',
    window.delUrl = '<?php echo url(request()->controller()."/del"); ?>';
    window.delAllUrl = '<?php echo url(request()->controller()."/delAll"); ?>';
    layui.config({
        base: yyadminPath + "/js/"
    })
</script>
</body>
</html>
<script>
   layui.use(['tableTreeDj','table','tableTool'], function() {
        let tableTree = layui.tableTreeDj
            ,table    = layui.table
            ,tableTool    = layui.tableTool
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
            {type:'checkbox'}
            ,{field:'id', title:'ID',width:80,sort:true}
            ,{field:'typename', title:'名称',width:'50%'}
            ,{field:'channeltype__typename', title:'所属模型',sort:true,width:120}
            ,{field:'sortrank', title:'排序',width:100,edit:true}
            ,{field:'ishidden', title:'显示',width:100,templet:tableTool.templet.switch}
            ,{field:'', width:"20%", title: '操作',templet:tableTool.templet.operate} 
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
            ,skin: 'line'
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
            , defaultShow: false
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
         tableTool.events.switch ();//开关点击事件
        tableTool.events.rowEdit ();//编辑排序     
        tableTool.events.operate();//操作
        tableTool.events.toolbar();//工具头事件
    });
    
</script>

