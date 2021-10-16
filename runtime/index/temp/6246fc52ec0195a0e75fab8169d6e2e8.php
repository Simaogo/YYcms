<?php /*a:1:{s:29:"../template/default/index.htm";i:1634312518;}*/ ?>
 <?php 
        $where=[];
        $menuList=[];
        $where[]=["ishidden","=",0];
        if("top"=="top") $where[] =["reid","=",0];
        if("top"=="son"){
            if(empty("2")) {
              $typeid =input("tid");
            }else{
              $typeid ="2";
            }
            $where[]=['reid','in', explode(",",$typeid)];
        }
        if("top"=="self") $where[] =["id","in", explode(",","2")];
           
        $ArctypeModel=new \app\common\model\Arctype();
        $menuList= $ArctypeModel->where($where)->order("sortrank asc")->limit(10)->select()->toArray();
       
        $tid= request()->param("tid");
        $currid=$ArctypeModel->childrenIds($menuList,$tid);
        $currid[]=$tid;
            foreach($menuList as $index=>$field){
                    $field["typeurl"]=url("template/list",["tid"=>$field["id"]]);
                    $field["currentstyle"]=in_array($field["id"],$currid)?"on":"";//栏目显示高亮
                    $typeid=$field["id"];//嵌套标签typeid传值
            ?> <a href="<?php echo htmlentities($field['typeurl']); ?>"><?php echo htmlentities($field['typename']); ?></a> <?php }  ?> 