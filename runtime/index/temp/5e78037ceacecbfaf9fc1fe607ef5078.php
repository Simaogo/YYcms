<?php /*a:1:{s:36:"../template/default/list_article.htm";i:1634381836;}*/ ?>

 <?php $list = \think\facade\Cache::get("list_tid_22_page_0"); foreach($list as $key =>$field) { 
                        $field["title"] = substr($field["title"],0,120);
                        $field["arcurl"] = "/view/aid/".$field["id"];
                        $field["picname"] = $field["litpic"];//缩略图
                        $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                   ?>

	<?php echo htmlentities($key); ?> => <?php echo htmlentities($field['title']); ?> - <HR><?php echo htmlentities($field['arcurl']); } ?>
{dede:pagelist listitem='end,' /}
