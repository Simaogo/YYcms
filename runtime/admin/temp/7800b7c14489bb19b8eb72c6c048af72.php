<?php /*a:2:{s:49:"E:\WWW\tp6dedecms\app\admin\view\login\index.html";i:1635936494;s:5:"param";i:0;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <title>后台登录-YYADMIN</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="/yyAdmin/layui/css/layui.css">
        <link rel="stylesheet" href="/yyAdmin/css/common.css">
        <style type="text/css">
                body {
                    background: url(/yyAdmin/images/admin-bg.jpg) 0% 0% / cover no-repeat;
                    min-height: 650px;
                }
              .login-main{
                  width: 420px;
                  height: 320px;
                  min-height: 320px;  
                  max-height: 320px;  
                  position: absolute;   
                  top: -250px;  
                  left: 0;  
                  bottom: 0;  
                  right: 0;  
                  margin: auto;  
                  padding: 20px;  
                  z-index: 130;  
                  border-radius: 8px;  
                  background-color: #fff;  
                  box-shadow: 0 3px 18px rgb(5 5 5 / 50%); 
                  font-size: 16px;
              }
              .close{
                  background-color: white;
                  border: none;
                  font-size: 18px;
                  margin-left: 410px;
                  margin-top: -10px;
              }
 
            .layui-input{
                border-radius: 5px;
                width: 300px;
                height: 40px;
                font-size: 15px;
            }
            .layui-form-item{
                margin-left: -20px;
            }
            #logoid{ 
                margin-top: -16px;
                  padding-left:150px; 
                  padding-bottom: 15px;
            }
            .layui-btn{
                margin-left: -50px;
                border-radius: 5px;
                width: 350px;
                height: 40px;
                font-size: 15px;
            }
            .verity{
                width: 120px;
            }
            .font-set{
                font-size: 13px;
                text-decoration: none; 
                margin-left: 120px;
            }
            a:hover{
             text-decoration: underline; 
            }
 
        </style>
    </head>
    <body>
        
            
                <div class="container">
                    <div class="layui-row">
                        <form class="layui-form" action="" method="post">
                        <div class="layui-col-md9 login-main">
                            <div class="layui-form-item" style="text-align:center">
                                <h2 style='paddding:15px;font-size: 20px;'>后台登录</h2>       
                            </div>
                          <div class="layui-form-item">
                            <label class="layui-form-label">用户名</label>
                            <div class="layui-input-block">
                              <input type="text" name="userid" required  lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input" value='admin'>
                            </div>
                          </div>
                          <div class="layui-form-item">
                            <label class="layui-form-label">密   码</label>
                            <div class="layui-input-inline">
                              <input type="password" name="pwd" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input" value ="admin">
                            </div>
                            <!-- <div class="layui-form-mid layui-word-aux">辅助文字</div> -->
                          </div>
                           <div class="layui-form-item">
                            <label class="layui-form-label">验证码</label>
                            <div class="layui-input-inline">
                                <div class ="layui-flex">
                                    <input type="text" name="verify" required  lay-verify="required" placeholder="请输入验证码" autocomplete="off" class="layui-input verity" value="">
                                    <img  style="height: 38px;margin-left:5px;cursor: pointer" onclick="this.src='<?php echo captcha_src(); ?>?'+Math.random()" src="<?php echo captcha_src(); ?>" alt="captcha" id="captcha">
                                </div>
                            </div>

                          </div>
                          <div class="layui-form-item">
                            <div class="layui-input-block">
                              <button class="layui-btn" lay-submit lay-filter="login">登陆</button>         
                            </div>
                          </div>
                        </div>
                      </form>
    
                    </div>
                </div>
        <script type="text/javascript" src="/yyAdmin/layui/layui.js"></script>
        <script>
            layui.use(['form', 'layedit', 'laydate'], function(){
              var form = layui.form
              ,layer = layui.layer
              ,$ = layui.jquery;
              //监听提交
              form.on('submit(login)', function(data){
                var data =data.field;
                $.post('<?php echo url("login/index"); ?>',data,function(res){
                    layer.msg(res.msg,{time:500},function(){
                        if(res.url){ 
                            window.location.href = res.url;
                        }else{
                            $('input[name="verify"]').val('');
                            $('#captcha').attr('src','<?php echo captcha_src(); ?>'+Math.random());
                        }
                    })
                })
                return false;
              });
            });

        </script>
    </body>
</html>