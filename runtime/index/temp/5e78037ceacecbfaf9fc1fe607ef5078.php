<?php /*a:2:{s:36:"../template/default/list_article.htm";i:1634731075;s:5:"param";s:24:"a:1:{s:3:"tid";s:1:"2";}";}*/ ?>
<form action="<?php echo url("template/message"); ?>" enctype="multipart/form-data" method="post" id="form">
            <input type="hidden" name="action" value="post">
            <input type="hidden" name="diyid" value="1">
            <input type="hidden" name="do" value="2">
          <div class="signWindow-info">
            <div class="signWindow-input">
              <ul>
                <li><span><i>*</i>您的名字：</span>
                  <input class="Name" type="" name="name" id="name">
                </li>
                <li><span>您的年龄：</span>
                  <input class="Old" type="" name="nianling">
                </li>
                <li><span><i>*</i>您的电话：</span>
                  <input class="Phone" type="" name="tel" id="tel">
                </li>
                <li><span>您的预算：</span>
                  <input class="Old" type="" name="yusuan">
                </li>
                
                <li><span>留言：</span>
                  <textarea class="Textarea" name="content"></textarea>
                </li>
                <input type="hidden" name="dede_fields" value="name,text;nianling,text;tel,text;yusuan,text;content,multitext">
<input type="hidden" name="dede_fieldshash" value="46af58021fbb07c816a0105e30ad1b72">
              </ul>
            </div>
            <a href="#">
            <input id="submit" type="submit" value="提交留言" class="signWindow-btn">
            </a> </div>
        </form>