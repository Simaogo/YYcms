<?php /*a:1:{s:29:"../template/default/index.htm";i:1633857512;}*/ ?>
<div class="onenews"> <?php 
            $where=[];
            $where[]=["arc.arcrank","=",0];
            if("all"!="all"){
               $where[]=["arc.typeid","in","all"];
            }
            if(in_array("h",["c","f","h","p","j"])){
                $where[]=["arc.flag","like","%h%"]; 
            }
            $ChanneltypeModel=new \app\common\model\Channeltype();
            $Channeltype=$ChanneltypeModel->find(1);
            $serializefield =explode(",",$Channeltype->serializefield);
            $list=\think\facade\Db::name("archives")
                            ->alias("arc")
                            ->join($Channeltype->addtable." add"," arc.id=add.aid","left")
                            ->where($where)
                            ->order("arc.sortrank asc,arc.id asc")->limit(0,10)
                            ->select()
                            ->toArray();   
            foreach($list as $index=>$field){
//                foreach($field as $k=>$v){
//                    if(in_array($k,$serializefield)){
//                        //$field[$k] = \fun\Process::decode_item($v);//序列化字段
//                    }
//                }
                $field["info"]=$field["description"]; //缩略图
                $field["litpic"]=explode(",",$field["litpic"]); //缩略图
                $field["arcurl"]=url("template/view",["aid"=>$field["aid"]])->build();
            ?>
    <h2><a href="<?php echo htmlentities($field['arcurl']); ?>"><?php echo htmlentities($field['title']); ?></a></h2>
    <p><?php echo htmlentities($field['info']); ?>...<a href="<?php echo htmlentities($field['arcurl']); ?>">[查看全文]</a></p>
    
                <?php 
            }
            ?>
         </div>