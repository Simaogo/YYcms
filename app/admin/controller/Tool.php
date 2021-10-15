<?php

namespace app\admin\controller;
use think\facade\View;
use think\facade\app;

class Tool extends \app\common\controller\Backend{
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
            $str = preg_replace("/typeid=(\d*)\s/i", 'typeid="$1" ', $str);
            $str = preg_replace("/titlelen=(\d*)\s/i", 'titlelen="$1" ', $str);
            $str = preg_replace("/channelid=(\d*)\s/i", 'channelid="$1" ', $str);
            $str = preg_replace("/row=(\d*)\s/i", 'row="$1" ', $str);

            $sysconfig = \app\common\model\Config::select();
            foreach ($sysconfig as $key => $val){
               $str = str_replace("{dede:global.".$val["varname"]."/}","{:syscfg('".$val["varname"]."')}",$str); 
               $str = str_replace("{dede:global.".$val["varname"]." /}","{:syscfg('".$val["varname"]."')}",$str);
            }
            
            $str = str_replace("[field:typeurl/]",'{$field.typeurl}',$str);
            $str = str_replace("[field:typeurl /]",'{$field.typeurl}',$str);
            
            $str = str_replace("[field:title/]",'{$field.title}',$str);
            $str = str_replace("[field:title /]",'{$field.title}',$str);
            
            $str = str_replace("[field:arcurl/]",'{$field.arcurl}',$str);
            $str = str_replace("[field:arcurl /]",'{$field.arcurl}',$str);
            
            $str = str_replace("[field:info/]",'{$field.info}',$str);
            $str = str_replace("[field:info /]",'{$field.info}',$str);
            $str = str_replace("dede","yycms",$str);
            $fileHandle = fopen($filename, 'w');
            fwrite($fileHandle, $str);
            $str = file_get_contents($filename);
            return json(['code'=>0,'msg'=>'success','data'=>$filename,'progress'=>input('page').'/'.input('count')]);
        }
    }
    
    public function replaceContent(){
        if(request()->isAjax()){
            $filename = $this->rootTempleta .input('filename');
            $str = file_get_contents($filename);
            $oldContent = input('oldContent');
            $newsContent = input('newsContent');
            $str = str_replace($oldContent,$newsContent,$str);
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
