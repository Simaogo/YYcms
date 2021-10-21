<?php /*a:2:{s:29:"../template/default/index.htm";i:1634718797;s:5:"param";i:0;}*/ ?>


 <?php 
            $menuList = \think\facade\Cache::get("d4c532af62eee071c8ca1067ff5b7275");
            $currid   = \think\facade\Cache::get("currid_d4c532af62eee071c8ca1067ff5b7275");
            $selftypeid = 0;  
            foreach($menuList as $key => $field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮 
                    $typeid = $field["id"];//嵌套标签typeid传值    
            ?>
        <li>
          <dl>
            <dt><a href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a></dt>
            <?php 
            if(isset($typeid)){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$typeid];
                $menuList =\app\common\model\Arctype::where($where)->select();
                //$menuList = $menuList ? $menuList->toArray():\think\facade\Cache::get("9650b3c01eb72e47bae00c149e89c221"); 
            }else{
                $menuList = \think\facade\Cache::get("9650b3c01eb72e47bae00c149e89c221");
            }
            $currid   = \think\facade\Cache::get("currid_9650b3c01eb72e47bae00c149e89c221");
            
            foreach($menuList as $index=>$field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
            <dd><a href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a></dd>
            <?php } 
                   
                 ?>
          </dl>
        </li>
		<?php $arclist = \think\facade\Cache::get("0ccc728b051b06ff0d28f9f582da6577");
                if(!$arclist){
                    $where=[];
                    $where[]=["arc.arcrank","=",0];
                    if(isset($selftypeid) && !empty("0")){
                        $typeid = $selftypeid != 0  ? $selftypeid:"0";
                    }
                    if(!empty("0")){
                        $typeid = "0";
                    }
                    //查找下级栏目
                    $typeList = \app\common\model\Arctype::select();
                    $typeidArr =[];
                    if(isset($typeid)){
                        if($typeList && $typeid){
                            foreach (explode(",",$typeid) as  $val){
                                $typeidArr = array_merge($typeidArr, \app\common\model\Arctype::childrenIds($typeList, $val));
                            }
                            $typeid = trim(array_reduce($typeidArr, function($carry, $item){
                                    return $carry . ",".$item;
                                }), ",");
                        }
                        if($typeid) $where[]=["arc.typeid","in",$typeid];
                    }
                    $whereRaw = "";
                    if(!empty("0")){
                        $whereRaw = "FIND_IN_SET('0', flag)";
                    }
                    $arclist=\think\facade\Db::name("archives")
                        ->alias("arc")
                        ->join("dede_addonarticle add"," arc.id=add.aid","left")
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.sortrank asc")
                        ->limit(0,15)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("0ccc728b051b06ff0d28f9f582da6577",$arclist);  
                 } 
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = substr($field["title"],0,120);
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"])?$field["redirecturl"] : \think\facade\Config::get("app.view_url")."/aid/".$field["id"];
            ?>

		<li><a href=""><?php echo htmlentities($field['arcurl']); ?> : <?php echo htmlentities($field['title']); ?></a></li>

		 <?php }  
                    
                unset($typeid); } ;
        
            $menuList = \think\facade\Cache::get("d4c532af62eee071c8ca1067ff5b7275");
            $currid   = \think\facade\Cache::get("currid_d4c532af62eee071c8ca1067ff5b7275");
            $selftypeid = 0;  
            foreach($menuList as $key => $field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮 
                    $typeid = $field["id"];//嵌套标签typeid传值    
            ?>
        <li>
          <dl>
            <dt><a href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a></dt>
            <?php 
            if(isset($typeid)){
                $where = [];
                $where[] = ["ishidden","=",0];
                $where[] = ["reid","=",$typeid];
                $menuList =\app\common\model\Arctype::where($where)->select();
                //$menuList = $menuList ? $menuList->toArray():\think\facade\Cache::get("9650b3c01eb72e47bae00c149e89c221"); 
            }else{
                $menuList = \think\facade\Cache::get("9650b3c01eb72e47bae00c149e89c221");
            }
            $currid   = \think\facade\Cache::get("currid_9650b3c01eb72e47bae00c149e89c221");
            
            foreach($menuList as $index=>$field){
                    $field["typeurl"] = \think\facade\Config::get("app.list_url")."/tid/".$field["id"];
                    $field["currentstyle"] = in_array($field["id"],$currid)?"on":"";//栏目显示高亮
            ?>
            <dd><a href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a></dd>
            <?php } 
                   
                 ?>
          </dl>
        </li>
		<?php $arclist = \think\facade\Cache::get("0ccc728b051b06ff0d28f9f582da6577");
                if(!$arclist){
                    $where=[];
                    $where[]=["arc.arcrank","=",0];
                    if(isset($selftypeid) && !empty("0")){
                        $typeid = $selftypeid != 0  ? $selftypeid:"0";
                    }
                    if(!empty("0")){
                        $typeid = "0";
                    }
                    //查找下级栏目
                    $typeList = \app\common\model\Arctype::select();
                    $typeidArr =[];
                    if(isset($typeid)){
                        if($typeList && $typeid){
                            foreach (explode(",",$typeid) as  $val){
                                $typeidArr = array_merge($typeidArr, \app\common\model\Arctype::childrenIds($typeList, $val));
                            }
                            $typeid = trim(array_reduce($typeidArr, function($carry, $item){
                                    return $carry . ",".$item;
                                }), ",");
                        }
                        if($typeid) $where[]=["arc.typeid","in",$typeid];
                    }
                    $whereRaw = "";
                    if(!empty("0")){
                        $whereRaw = "FIND_IN_SET('0', flag)";
                    }
                    $arclist=\think\facade\Db::name("archives")
                        ->alias("arc")
                        ->join("dede_addonarticle add"," arc.id=add.aid","left")
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.sortrank asc")
                        ->limit(0,15)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("0ccc728b051b06ff0d28f9f582da6577",$arclist);  
                 } 
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = substr($field["title"],0,120);
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"])?$field["redirecturl"] : \think\facade\Config::get("app.view_url")."/aid/".$field["id"];
            ?>

		<li><a href=""><?php echo htmlentities($field['arcurl']); ?> : <?php echo htmlentities($field['title']); ?></a></li>

		 <?php }  
                    
                unset($typeid); } ;
        $arclist = \think\facade\Cache::get("ac8b9c012832f8796a8f0f539e1ed9a8");
                if(!$arclist){
                    $where=[];
                    $where[]=["arc.arcrank","=",0];
                    if(isset($selftypeid) && !empty("37")){
                        $typeid = $selftypeid != 0  ? $selftypeid:"37";
                    }
                    if(!empty("37")){
                        $typeid = "37";
                    }
                    //查找下级栏目
                    $typeList = \app\common\model\Arctype::select();
                    $typeidArr =[];
                    if(isset($typeid)){
                        if($typeList && $typeid){
                            foreach (explode(",",$typeid) as  $val){
                                $typeidArr = array_merge($typeidArr, \app\common\model\Arctype::childrenIds($typeList, $val));
                            }
                            $typeid = trim(array_reduce($typeidArr, function($carry, $item){
                                    return $carry . ",".$item;
                                }), ",");
                        }
                        if($typeid) $where[]=["arc.typeid","in",$typeid];
                    }
                    $whereRaw = "";
                    if(!empty("0")){
                        $whereRaw = "FIND_IN_SET('0', flag)";
                    }
                    $arclist=\think\facade\Db::name("archives")
                        ->alias("arc")
                        ->join("dede_addonarticle add"," arc.id=add.aid","left")
                        ->where($where)
                        ->where($whereRaw)
                        ->order("arc.sortrank asc")
                        ->limit(0,15)
                        ->select()
                        ->toArray();
                    $arclist = \think\facade\Cache::get("ac8b9c012832f8796a8f0f539e1ed9a8",$arclist);  
                 } 
            foreach($arclist as $key=>$field){
                $field["info"]=$field["description"];
                $field["title"] = substr($field["title"],0,160);
                $field["picname"] = $field["litpic"];//缩略图
                $field["imgurls"] = isset($field["imgurls"])&&isset($field["imgurls"]) ? explode(",",$field["imgurls"]) :""; //图集
                $field["arcurl"] = in_array("j",explode(",",$field["flag"])) && !empty($field["redirecturl"])?$field["redirecturl"] : \think\facade\Config::get("app.view_url")."/aid/".$field["id"];
            ?>
      <li><a href=""><?php echo htmlentities($field['arcurl']); ?> : <?php echo htmlentities($field['title']); ?></a></li>
       <?php }  
                    
                ?>