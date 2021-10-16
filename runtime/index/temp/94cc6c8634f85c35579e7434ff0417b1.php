<?php /*a:1:{s:34:"template/default/index_article.htm";i:1629962797;}*/ ?>
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
        <div class="wrap clearfix"> {dede:include filename="left.htm"/}
            <div class="main_r fr">
                <div class="page_content">
                    <div class="page_tit">
                        <h3>{dede:field.typename/}</h3>
                    </div>
                    <div class="content"> {dede:field.content/} </div>
                </div>
            </div>
        </div>
    </div>
</div>
{dede:include filename="footer.htm"/}
</body>
</html>