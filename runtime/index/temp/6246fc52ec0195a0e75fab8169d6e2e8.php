<?php /*a:2:{s:29:"../template/default/index.htm";i:1634578617;s:5:"param";i:0;}*/ ?>
<?php 
            $menuList = \think\facade\Cache::get("5be89770e43cc3a0d2f35f13a71f5b0f");
            $currid   = \think\facade\Cache::get("currid_5be89770e43cc3a0d2f35f13a71f5b0f");
            $selftypeid = 0; 
            foreach($menuList as $index=>$field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
                    \think\facade\View::assign("typeid",$field["id"]);   
                    $typeid = $field["id"];//嵌套标签typeid传值
                  
            ?>
    <div class="i_box7 clearfix">
        <div class="center">
            <div class="box4_tit">
                <p>企业认证 · <i>海量客户合作案例</i></p>
                <span>Fitness exercise · Provide you with a large number of customer cooperation cases</span> </div>
            <div class="i_box7_content clearfix">
                <div class="fl">
                    <h3><?php echo htmlentities($field['typename']); ?></h3>
                    <ul>
					    <?php 
            if(isset($typeid)){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$typeid];
                $menuList =\app\common\model\Arctype::where($where)->select();
                $menuList = $menuList ? $menuList->toArray():\think\facade\Cache::get("9650b3c01eb72e47bae00c149e89c221"); 
            }else{
                $menuList = \think\facade\Cache::get("9650b3c01eb72e47bae00c149e89c221");
            }
            $currid   = \think\facade\Cache::get("currid_9650b3c01eb72e47bae00c149e89c221");
            foreach($menuList as $index=>$field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
                        <li><a href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a></li>
						<?php } ?>
                    </ul>
                </div>
                <div class="fr">
                    <h3>海量客户合作案例</h3>
                    <ul>
					    <?php $arclist = \think\facade\Cache::get("13a66aaa5fcbb5645cba5a454a90fa2dc");
                if(!$arclist){
                    $where=[];
                    $where[]=["arc.arcrank","=",0];
                    if(!isset($typeid)){ //标签嵌套
                       $typeid = $selftypeid == 0 ?0:$selftypeid;
                    }
                    //查找下级栏目
                    $typeList = \app\common\model\Arctype::select();
                    $typeidArr =[];
                    if($typeList && $typeid){
                        foreach (explode(",",$typeid) as  $val){
                            $typeidArr = array_merge($typeidArr, \app\common\model\Arctype::childrenIds($typeList, $val));
                        }
                        $typeid = trim(array_reduce($typeidArr, function($carry, $item){
                                return $carry . ",".$item;
                            }), ",");
                    }
                    if($typeid) $where[]=["arc.typeid","in",$typeid];
                    $whereRaw = "";
                    if(0){
                        $whereRaw = "FIND_IN_SET('$flag', flag)";
                    }
                    $arclist=\think\facade\Db::name("archives")
                        ->alias("arc")
                        ->join("dede_addonarticle add"," arc.id=add.aid","left")
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.sortrank asc")
                        ->limit(0,6)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("3a66aaa5fcbb5645cba5a454a90fa2dc",$arclist);  
                 } 
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = substr($field["title"],0,120);
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"])?$field["redirecturl"] : \think\facade\Config::get("app.view_url")."/aid/".$field["id"];
            ?>
                        <li>
                            <div class="pic"> <a href="<?php echo htmlentities($field['arcurl']); ?>">
                                <div class="imgauto"> <img src="<?php echo htmlentities($field['litpic']); ?>" alt="<?php echo htmlentities($field['title']); ?>" /> </div>
                                </a> </div>
                            <div class="text"> <a href="<?php echo htmlentities($field['arcurl']); ?>"><?php echo htmlentities($field['title']); ?></a> </div>
                        </li>
						 <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
	<?php } ?>