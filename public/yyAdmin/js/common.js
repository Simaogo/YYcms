layui.config({
    base: yyAdminPath+'/js/',
}).use(["yyadmin", "tabRightMenu"], function () {
    var yyadmin = layui.yyadmin;
    var tabRightMenu = layui.tabRightMenu;
    // 渲染 tab 右键菜单.
    tabRightMenu.render({
        filter: "lay-tab",
        pintabIDs: ["main"],
        width: 110,
    });
});