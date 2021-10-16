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
            $default = syscfg('cfg_df_style');
            $filename = $this->rootTempleta .input('filename');
            $str = file_get_contents($filename);
            //替换配置字段
            $sysconfig = \app\common\model\Config::select();
            foreach ($sysconfig as $key => $val){
               $str = str_replace("{dede:global.".$val["varname"]."/}","{:syscfg('".$val["varname"]."')}",$str); 
               $str = str_replace("{dede:global.".$val["varname"]." /}","{:syscfg('".$val["varname"]."')}",$str);
            }
            //字段处理
            $str = preg_replace("/\[field:(\w+)\/]/i", '{$field.$1}', $str);
            $str = preg_replace("/\[field:(\w+)\s+\/]/i", '{$field.$1}', $str);
            
            //替换包含文件
            $str = preg_replace('/{dede:include\s+filename="(.*).htm"\/}/i','{include file="../template/'.$default.'/$1.htm"/}',$str);
            $str = preg_replace('/{dede:include\s+filename=\'(.*).htm\'\/}/i','{include file="../template/'.$default.'/$1.htm"/}',$str);
            //内容页字段
            $str = preg_replace('/{dede:field.(.*)\/}/i','{$field.$1}',$str);
            $str = preg_replace('/function=\'.*\'/i','',$str);
            $str = preg_replace("/function=\".*\"/i",'',$str);
            //列表页字段
            $str = preg_replace("{dede:field name='position'/}",'{$field.position}',$str);
           // $str = preg_replace("{dede:pagelist(.*)}",'{$page $1}',$str);
            $str = preg_replace("{dede:field name=\"typeurl\"\/}",'{$field.typeurl}',$str);
            $str = preg_replace("{dede:field name='typeurl'\/}",'{$field.typeurl}',$str);
            $str = preg_replace("{dede:field name=\"typename\"\/}",'{$field.typename}',$str);
            $str = preg_replace("{dede:field name='position'/}",'{$field.position}',$str);
            $str = preg_replace("{dede:field name=\"position\"/}",'{$field.position}',$str);
            
            //替换友情链接标签 
            $str = str_replace("[field:link/]",'<a href="{$field.url}" target="_blank">{$field.webname}</a>">',$str);
            $str = str_replace("{dede:flink",'{yycms:flink',$str);
            
            $str = str_replace("dede:","yycms:",$str);
            
            //特殊字符串
            $str = preg_replace("/typeid=(\d*)\s/i", 'typeid="$1" ', $str);
            $str = preg_replace("/titlelen=(\d*)\s/i", 'titlelen="$1" ', $str);
            $str = preg_replace("/channelid=(\d*)\s/i", 'channelid="$1" ', $str);
            $str = preg_replace("/row=(\d*)\s/i", 'row="$1" ', $str);
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
