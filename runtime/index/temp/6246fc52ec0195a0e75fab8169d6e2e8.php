<?php /*a:1:{s:29:"../template/default/index.htm";i:1634108062;}*/ ?>
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
            $test_arr=[[1,3,5,7,9],[2,4,6,8,10]];$__LIST__ = $test_arr[1]; if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$body): $mod = ($i % 2 );++$i;?>
dddddddd<br>
<?php endforeach; endif; else: echo "" ;endif; ?>
<img src='/uploads/20211013\085006a7e5214b9c017a633c6fb79da5.jpg'>