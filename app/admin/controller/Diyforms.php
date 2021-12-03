<?php
namespace app\admin\controller;

use app\common\model\Diyforms as DiyformsModel;
use think\facade\View;
use think\facade\Db;
use think\facade\Config;
class Diyforms extends \app\common\controller\Backend{
    
    public function index(){
        if(request()->isAjax()){
            $list = DiyformsModel::select();
            $prefix = Config::get('database.connections.mysql.prefix');
            foreach ($list as $key => $val){
                 $table = replacePrefix($val['table']);
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
        $id = input('id');
         if(request()->isAjax()){
             $post = input();
             $table = $post['table'];
             $this->isHasField('diyforms', 'captcha','int'); 
             $fieldset = json_decode($post['fieldset'],true);
             if($fieldset){
                  //添加字段fieldset
                $this->isHasField('diyforms', 'fieldset','text'); 
                foreach ($fieldset as $key => $val ){
                   $this->isHasField($table, $val['name'],$val['type']);
                }
             } else {
                 return json(['code'=>1,'msg'=>'Please set the field']);
             }
             if($id){
                 unset($post['id']);
                 DiyformsModel::where(['diyid'=>$id])->update($post);
             }else{
                 if (!DiyformsModel::where(['table'=>$post['table']])->find())
                    DiyformsModel::create($post); 
                else 
                    return json(['code'=>1,'msg'=>'Table already exists']);
             }   
             return json(['code'=>0,'msg'=>'success']);
         }
         $view = [];
         if($id){
             $view['formData'] =  DiyformsModel::where(['diyid'=>$id])->find()->toArray();
         }
         View::assign($view);
         return View::fetch();
    }
    
    public function diyData(){
        if(request()->isAjax()){
            $diyforms= DiyformsModel::where(['diyid'=>input('id')])->find();
            $table = replacePrefix($diyforms->table);
            $fieldset = $diyforms ->fieldset;
            $list = Db::name(replacePrefix($diyforms->table))->select()->toArray();
            if(!$fieldset){
                 $prefix = Config::get('database.connections.mysql.prefix');
                 $sql = 'show full columns from `'.$prefix .$table.'`';
                 $tableParam = Db::query($sql);
                 $fieldset = [];
                 foreach ($tableParam as $key => $val){
                     $fieldset[$key]['name'] = $val['Field'];
                     $fieldset[$key]['itemname'] = '';
                 }
            }
            foreach($list as $key => $val){
                $str = '';
                foreach($fieldset as $k => $v){
                   $name = $v['name'];
                   if(isset($val[$name])) $str .= $v['itemname'] .':'.$val[$name].'<br/>';
                }
                $list[$key]['create_time'] = isset($val['create_time']) ? date('Y-m-d H:i:s',$val['create_time']):'';
                $list[$key]['data'] = $str;
            }
            
            return json(['code'=>0,'msg'=>'success','data'=>$list,'count'=>200]);
        }
         return View::fetch();
    }
}
