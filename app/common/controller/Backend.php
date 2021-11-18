<?php

namespace app\common\controller;

use think\facade\Session;
use think\App;
use app\common\controller\Jump;
use think\facade\Db;
class Backend extends \app\BaseController{
    
    use Jump;
    public $model;
    public function __construct(App $app)
    {
        // 控制器初始化
        $this->initialize();
    }
    // 初始化
    public function initialize()
    {
        if(!Session::get('admin')){
            $this->error('登录超时!', url('login/index'));
        }
        //初始化权限
        $admin = Session::get('admin');
        if($admin->userid != 'admin'){
        $authRule = \app\admin\model\Admintype::where('rank',$admin['usertype'])->value('purviews');
        $controller = request()->controller();
      
        if(trim($authRule,' ') != 'admin_AllowAll' && $controller != 'Index' && $controller !='Login'){
            dump($authRule);
            $authRule = explode(',', $authRule);
            
            $href = str_replace('.html','',request()->pathinfo());
            $authRuleId = \app\admin\model\AuthRule::where('href',$href)->value('id');
           
             if(!in_array($authRuleId, $authRule)){
                 $this->error('没有权限操作', url('index/home'));
             }

        }
       }
    }
    /**
     * 隐藏显示开关
     * @return type
     */
    public function rowEdit(){
        if(request()->isAjax()){
            $post = input();
            $name = $post['name'];
            $data = [
                 $name  => $post['value'],
            ];
            $where = ['id'=>$post['id']];
            if($this->model::where($where)->save($data)){
                return json(['code'=>0,'msg'=>'success']);   
            } else {
                return json(['code'=>0,'msg'=>'error']);   
            }
        }
    }
    
    public function del(){
        if(request()->isAjax()){
            $id = input('id');
            $this->model::where('id',$id)->delete();
            return json(['code'=>0,'msg'=>'success']);
        }
    }
    public function delAll(){
        if(request()->isAjax()){
            $ids = input('ids');
            if($this->model && $ids){
                $this->model::where('id','in',$ids)->delete();
                return json(['code'=>0,'msg'=>'success']);   
            } else {
                return json(['code'=>0,'msg'=>'error']);
            } 
        }
    }
    
    /**
     * 检测数据表是否在字段,没有则添加字段
     * @param type $table 表名
     * @param type $field 字段名
     * @param type $type  类型
     * @param type $default  默认值
     * @param type $length  长度
     */
    public function isHasField($tableName, $field, $type ='VARCHAR', $length = 10, $default ='NULL'){
         $prefix = \think\facade\Config::get('database.connections.mysql.prefix');
         $table = $prefix .'' .str_replace($prefix,'', $tableName); //统一表前缀
         $result = Db::query('show tables like "'.$table.'"');
         if(!$result){
            $sql ='CREATE TABLE IF NOT EXISTS `'.$table.'`(
               `id` INT UNSIGNED AUTO_INCREMENT,
               `create_time` INT(10) NOT NULL,
               `'.$field.'` '.$type.'('.$length.') '.$default.',
               `update_time` INT(10) NOT NULL,
               PRIMARY KEY ( `id` )
            )ENGINE = InnoDB DEFAULT CHARSET=utf8;';
            Db::query($sql);
         }else{
            $sql = 'show full columns from `'.$table.'`';
            $tableParam = Db::query($sql);
            $fieldsetStr = trim(array_reduce($tableParam, function($carry, $item){
                  return $carry . ','.$item['Field'];
             }), ',');
            $fieldset = explode(',',$fieldsetStr);
            if(!in_array($field, $fieldset)){
                $sql = 'ALTER TABLE '.$table.' ADD '.$field.' '.$type.'('.$length.')';
            } else {
                 $sql = 'ALTER TABLE '.$table.' modify column '.$field.' '.$type.'('.$length.')';  //修改类型
            }
            Db::query($sql);
//            if($type != 'text'){
//                $sql = 'alter table '.$table.' alter column '.$field.' drop default';
//                Db::query($sql);
//                $sql = 'ALTER TABLE '.$table.' alter column '.$field.' set default "'.$default.'"';  //设置默认
//                Db::query($sql);
//            }
        }
        return  true;
    }
}
