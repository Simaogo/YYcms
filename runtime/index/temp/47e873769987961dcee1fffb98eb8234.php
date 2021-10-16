<?php /*a:1:{s:33:"template/default/list_article.htm";i:1629365525;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
<title>{dede:field.typename/}_{dede:global.cfg_webname/}</title>
<meta name="keywords" content="{dede:field name='keywords'/}" />
<meta name="description" content="{dede:field name='description' function='html2text(@me)'/}" />
<script type="text/javascript" src="/skin/js/jquery-1.12.4.min.js"></script>
<link rel="stylesheet" href="/skin/css/style.css">
<link rel="stylesheet" href="/skin/css/font-awesome.min.css">
<script type="text/javascript" src="/skin/js/js.js"></script>
<script type="text/javascript" src="/skin/js/superslide.js"></script>
</head>
<body>
{dede:include filename="head.htm"/}
{dede:include filename="banner.htm"/}
<div class="container">
    {dede:include filename="position.htm"/}
    <div class="center">
        <div class="wrap clearfix">
            {dede:include filename="left.htm"/}
            <div class="main_r fr">
                <div class="art_list">
                    <ul>
					    {dede:list pagesize=6}
                        <li>
                            <div class="fl"> <a href="[field:arcurl/]"> <img src="[field:litpic/]" alt="[field:fulltitle/]" /> </a> </div>
                            <div class="fr"> <a href="[field:arcurl/]">[field:title/]</a> <span>[field:pubdate function="MyDate('Y-m-d',@me)"/]</span>
                                <p>[field:description/]...</p>
                            </div>
                        </li>
						{/dede:list}
                    </ul>
                </div>
                <div class="pages">
                    <div class="pagination"><ul>{dede:pagelist listitem="index,end,pre,next,pageno" listsize="5"/}</ul></div>
                </div>
            </div>
        </div>
    </div>
</div>
{dede:include filename="footer.htm"/}
</body>
</html>
