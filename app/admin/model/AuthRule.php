<?php
namespace app\admin\model;

class AuthRule extends \think\model{
    protected static function init()
     {
        
     }

     public static function authRuleTree($list ,$lefthtml = '|----' , $pid = 0 , $level = 0 ){
         $arr = array();
         foreach ($list as $v){
             if ($v['pid'] == $pid) {
                 $v['level']      = $level + 1;
                 $v['spread']     = true;
                 $v['lefthtml']   = $level ? str_repeat($lefthtml,$level):"";
                 $v['children']   = $arr = array_merge($arr, self::authRuleTree($list, $lefthtml, $v['id'], $level+1));
                 $arr[] = $v;
             }
         }
         return $arr;
     }
     public static function childrenIds($list,$id){
         $ids= [];
         foreach ($list as $v){
             if ($v['reid'] == $id) {
                 $ids[] = $v['id'];
                 $ids = array_merge($ids,self::childrenIds($list, $v['id']));
             }
         }
         $ids[] = intval($id);
         return array_unique($ids);
     }
     
     public static function childTree($list ,$checkedIds = [], $pid = 0 , $level = 0){
        $arr = array();
        foreach ($list as $v){
            if ($v['pid'] == $pid) {
                $v['level']      = $level + 1;
                $v['field']      = 'purviews[]';
                $v['checked']    = in_array($v['id'], $checkedIds) ? 1 : 0;
                $v['children']   = self::childTree($list,$checkedIds ,$v['id'], $level+1);
                $arr[] = $v;
            }
        }
        return $arr;
    }
}
