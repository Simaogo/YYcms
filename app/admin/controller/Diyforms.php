<?php
namespace app\admin\controller;

use app\common\model\Diyforms as DiyformsModel;
use think\facade\View;
use think\facade\Db;
class Diyforms extends \app\common\controller\Backend{
    public function index(){
        if(request()->isAjax()){
            $list = DiyformsModel::select();
            
            foreach ($list as $key => $val){
                 $table = str_replace('dede_','' ,$val['table']);
                 $data  = Db::name($table)->select()->toArray();
                 $str = '';
                 if($data){
                     foreach ($data as $k =>$v){
                         
                         $rowdata = trim(array_reduce($v, function($carry, $item){
                            return $carry . ','.$item;
                        }), ',');
                        $str .= $rowdata .'----------------';
                     }
                 }
                 $list[$key]['data'] = $str ;

            }
            return json(['code'=>0,'msg'=>'success','data'=>$list,'count'=>200]);
        }
         return View::fetch();
    }
    
    public function addEdit(){
         if(request()->isAjax()){
             
         }
         $view = [];
         return View::fetch();
    }
}
