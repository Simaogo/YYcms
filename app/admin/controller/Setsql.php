<?php
namespace app\admin\controller;
use think\facade\View;
use think\facade\app;
use think\facade\Config;
use think\facade\Db;

class Setsql extends \app\common\controller\Backend{
    
    public function index(){
        if(request()->isAjax()){
            $data = Db::query('show tables');
            $dbName = config('database.connections.mysql.database');
            foreach($data as $key => $val){
                $data[$key]['tablename'] = $tableName = $val['Tables_in_'. $dbName];
            }
            return json(['code'=>0,'msg'=>'success','data'=>$data]);
        }
        return View::fetch();
    }
    
    public function importYysql(){
        if(request()->isAjax()){
            $sqlFile = root_path().'upgrade.sql'; //导入YYADMIN数据库
            importSqlData($sqlFile);
            return json(['code'=>0,'msg'=>'success']);
        }
    }
    /**
     * 修改表前缀
     * @return type
     */
    public function replacePrefix(){
       if(request()->isAjax()){
            $newPrefix = 'yy';
            $dbName = config('database.connections.mysql.database');
            $data = Db::query('show tables');
            foreach ($data as $key => $val){
                 $tableName = $val['Tables_in_'. $dbName];
                 $oldPrefix = strstr($tableName,'_',true);//旧表前缀
                 $table = strstr($tableName,'_');//表带_xxxx
                 $replaceSql = 'alter table `'.$tableName.'` rename to `'.$newPrefix .$table.'`';
                 $res = Db::query($replaceSql);
            }
            //修改数据库配置
            return json(['code'=>0,'msg'=>'success']);
        }
            
    }
    /**
     *删除多余表
     */
    public function deleteAll(){
        if(request()->isAjax()){
            $tableArr = [
                '_sysconfig',
                '_diyforms',
                '_mytag',
                '_myppttype',
                '_myppt',
                '_admin',
                '_admintype',
                '_archives',
                '_arctype',
                '_channeltype',
                '_flink',
                '_flinktype',
                '_uploads',
                '_addonarticle',
                '_admin_log',
                '_auth_rule'
                ];
            //模型表单
            $addtable =\app\common\model\Channeltype::field('addtable')->select()->toArray();
            $addtable = trim(array_reduce($addtable, function($carry, $item){
                    return $carry.','.$item['addtable'];
                }), ',');
            $addtable = explode(',',$addtable);  
            //自定义表单
            $diyform = \app\common\model\Diyforms::field('table')->select();
            $diyforms = [];
            if($diyform){
                 $diyforms = trim(array_reduce($diyform->toArray(), function($carry, $item){
                    return $carry.','.$item['table'];
                }), ',');
                $diyforms = explode(',',$diyforms);
            }
            $tables = Db::query('show tables');
            $dbName = config('database.connections.mysql.database');
            foreach ($tables as $key =>$val){
                $tableName = $val['Tables_in_'. $dbName];
                if(!in_array($tableName,$diyforms) && !in_array($tableName,$addtable)){ //自定义表单和模型附表 排除
                    $tablestr = strstr($tableName,'_');
                    if(!in_array($tablestr, $tableArr)){
                           $sql = 'DROP TABLE `'.$tableName .'`';
                           Db::query($sql);
                    }
                }
            }
            return json(['code'=>0,'msg'=>'success']);
        }
    }

    public function dataBackup(){

        

    }
}
