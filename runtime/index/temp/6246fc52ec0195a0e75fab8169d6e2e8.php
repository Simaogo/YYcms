<?php /*a:1:{s:29:"../template/default/index.htm";i:1633950020;}*/ ?>
<?php $currentstyle="";
            $where=["ishidden"=>0,"reid"=>0];
            $ArctypeModel=new \app\common\model\Arctype();
            $menuList= $ArctypeModel->where($where)->order("sortrank","desc")->limit(0,10)->select()->toArray(); 
            $currid=[];
            if(input("tid")){
                 $currid=$ArctypeModel->artypeCurrId(input("tid"));
                 $currid[]=input("tid");
            }
            foreach($menuList as $index=>$field){
                $field["typeurl"]=url("template/list",["tid"=>$field["id"]]);
                $currentstyle=in_array($field["id"],$currid)?"cur":"";//栏目显示高亮
                $typeid=$field["id"];//嵌套标签typeid传值
            ?>
<li><a href='<?php echo htmlentities($field['typeurl']); ?>' > 123123<?php echo htmlentities($field['typename']); ?></a></li>

                <?php 
            }
            ?>
        