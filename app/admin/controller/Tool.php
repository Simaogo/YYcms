<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\admin\controller;
use think\facade\View;
use think\facade\app;
/**
 * Description of Tool
 *
 * @author Administrator
 */
class Tool {
    private $rootTempleta;
    
    public function __construct() {
        $this->rootTempleta =App::getRootPath().'\template\default\/';
    }
    public function index(){
       if(request()->isAjax()){
           $data = [];
           
           $d = scandir($this->rootTempleta);
           $i = 0;
           foreach ($d as $k=>$v){
               if($v!='.'&&$v!='..'){
                 $data[$i]['id'] =$i+1;
                 $data[$i]['filename'] =$v;
                 $i++;
               }
           }
           return json(['code'=>0,'msg'=>'success','data'=>$data]);
       }
       return View::fetch();
    }
    public function replaceTag(){
        if(request()->isAjax()){
            $filename = $this->rootTempleta .input('filename');
            $str = file_get_contents($filename);
            $str = str_replace("dede","Ylcms",$str);
            $str = str_replace("[field:typeurl/]",'{$field.typeurl}',$str);
            $str = str_replace("[field:title/]",'{$field.title}',$str);
            $str = str_replace("[field:title /]",'{$field.title}',$str);
            $str = str_replace("[field:arcurl/]",'{$field.arcurl}',$str);
            $fileHandle = fopen($filename, 'w');
            fwrite($fileHandle, $str);
            $str = file_get_contents($filename);
            return json(['code'=>0,'msg'=>'success','data'=>$filename,'progress'=>input('page').'/'.input('count')]);
        }
    }
    public function addEdit(){
        $filename = $this->rootTempleta .input('filename');
        $str = file_get_contents($filename);
        View::assign('filecont',$str);
        return View::fetch();
    }
}
