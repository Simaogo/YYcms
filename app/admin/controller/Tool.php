<?php

namespace app\admin\controller;
use think\facade\View;
use think\facade\app;
use think\facade\Config;

class Tool extends \app\common\controller\Backend{
    private $view_template_path;
    public function __construct() {
        $this->view_template_path = root_path().'/template/'. syscfg("cfg_df_style") .'/';
    }
    public function index(){
       if(request()->isAjax()){
           $data = [];
           $d = scandir($this->view_template_path);
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
            $filename = $this->view_template_path .input('filename');
            $str = file_get_contents($filename);
            //手机端标签替换
            $str = preg_replace("/href=\"(list.php?tid=.*)\"/i", '{$field.typeurl}', $str);
            $str = preg_replace('/href=\'(list.php?tid=.*)\'/i', '{$field.typeurl}', $str);
            $str = preg_replace("/href=\"(view.php?aid=.*)\"/i", '{$field.arcurl}', $str);
            $str = preg_replace('/href=\'(view.php?aid=.*)\'/i', '{$field.arcurl}', $str);
            $str = preg_replace('/\/m/i', '/', $str);
            
            //处理标签内function
            $str = preg_replace('/function=\'.*\'/i','',$str);
            $str = preg_replace("/function=\".*\"/i",'',$str);
            //替换配置字段
            $str = preg_replace("/{dede:global.(\w+)\/}/i","{:syscfg('$1')}",$str); 
            //替换友情链接标签 
            $str = preg_replace("/\[field:link\s+\/\]/i",'<a href="{$field.url}" target="_blank">{$field.webname}</a>',$str);
            //替换包含文件
            $str = preg_replace('/{dede:include\s+filename="(.*).htm"\/}/i','{include file="$1"/}',$str);
            $str = preg_replace('/{dede:include\s+filename=\'(.*).htm\'\/}/i','{include file="$1"/}',$str);
            //关键词、描述、标题
            $str = preg_replace("/{dede:field.title\/}/i",'{$yy.field.title}',$str);
            $str = preg_replace("/{dede:field.title\s+\/}/i",'{$yy.field.title}',$str);
            
            $str = preg_replace("/{dede:field.description\s+\/}/i",'{$yy.field.description}',$str);
            $str = preg_replace("/{dede:field.description\s+\/}/i",'{$yy.field.description}',$str);
            
            $str = preg_replace("/{dede:field.keywords\/}/i",'{$yy.field.keywords}',$str);
            $str = preg_replace("/{dede:field.keywords\s+\/}/i",'{$yy.field.keywords}',$str);
            
            $str = preg_replace("/{dede:field\s+name=\"keywords\"\s+\/}/i",'{$yy.field.keywords}',$str);
            $str = preg_replace("/{dede:field\s+name='keywords'\/}/i",'{$yy.field.keywords}',$str);
            
            $str = preg_replace("/{dede:field\s+name=\"description\"\s+\/}/i",'{$yy.field.description}',$str);
            $str = preg_replace("/{dede:field\s+name='description'\/}/i",'{$yy.field.description}',$str);
            //位置字段替换

           
            //列表页字段
            $str = preg_replace("/{dede:field\s+name='(.*)'\/}/i",'{$field.$1}',$str);
            $str = preg_replace("/{dede:field name=\"(.*)\"\/}/i",'{$field.$1}',$str);
            $str = preg_replace("/{dede:field\s+name=(\w+)\/}/i",'{$field.$1}',$str);
            
            $str = preg_replace("/{dede:field.(\w+)\/}/i",'{$yy.field.$1}',$str);
            $str = preg_replace('/{dede:field.(\w+)\s+\/}/i','{$yy.field.$1}',$str);

            //内容页字段
            $str = preg_replace('/{dede:field.(\w+)\/}/i','{$field.$1}',$str);
            $str = preg_replace('/{dede:field.(\w+)\s+\/}/i','{$field.$1}',$str);
            $str = preg_replace('/{dede:field.(\w+)\\/}/i','{$field.$1}',$str);
            //$str = str_replace('<script src="{$field.phpurl\'/}/count.php?view=yes&aid={dede:field name=\'id\'/}&mid={dede:field name=\'mid}" type=\'text/javascript\' language="javascript"></script>','{$info.click}',$str);
            //字段处理
            $str = preg_replace("/\[field:(\w+)\/]/i", '{$field.$1}', $str);
            $str = preg_replace("/\[field:(\w+)\s+\/]/i", '{$field.$1}', $str);
            $str = preg_replace("/currentstyle=\".*\"/i", 'currentstyle="active"', $str);
            
           // $str = str_replace("dede:","yycms:",$str);
            $str = str_replace("dede:channel","yycms:channel",$str);
            $str = str_replace("dede:sql","yycms:channel",$str);
            $str = str_replace("dede:channelartlist","yycms:list",$str);
            $str = str_replace("dede:list","yycms:list",$str);
            $str = str_replace("dede:arclist","yycms:arclist",$str);
            $str = str_replace("dede:type","yycms:type",$str);
            $str = str_replace("dede:flink","yycms:flink",$str);
            $str = str_replace("dede:pagelist","yycms:pagelist",$str);
            $str = str_replace("dede:prenext","yycms:prenext",$str);
            //搜索
            $list_url = config('app.list_url');
            $str = preg_replace("/\/plus\/search.php/i", '{:url("template/list",["serach"=>1])}', $str);
            $str = preg_replace("/\/plus\/diy.php/i", '{:url("template/message")}', $str);
            //特殊字符串
            $str = preg_replace("/typeid=(\d+)\s+/i", 'typeid="$1" ', $str);
            $str = preg_replace("/typeid=(\d+)/i", 'typeid="$1" ', $str);
            $str = preg_replace("/titlelen=(\d*)\s/i", 'titlelen="$1" ', $str);
            $str = preg_replace("/channelid=(\d*)\s/i", 'channelid="$1" ', $str);
            $str = preg_replace("/row=(\d*)\s/i", 'row="$1" ', $str);
            $str = preg_replace("/pagesize=(\d+)/i", 'pagesize="$1" ', $str);
            $str = preg_replace("/field.content}/i", 'yy.field.content|raw}', $str);
            $str = preg_replace("/field.body}/i", 'yy.field.body|raw}', $str);
            $str = preg_replace("/field.position}/i", 'yy.field.position|raw}', $str);
            
            $str = preg_replace("/channel\s+type=(\w+)\s+/i", 'channel type="$1" ', $str);
          
            $str = preg_replace("/field.typedir}/i", 'field.typedir}', $str);
            $str = preg_replace("/field.pic}/i", 'field.picname}', $str);
            $str = preg_replace("/field.fulltitle}/i", 'field.title}', $str);
           
            
            //halt($str);
           
            $fileHandle = fopen($filename, 'w');
            
            fwrite($fileHandle, $str);
            $str = file_get_contents($filename);
            return json(['code'=>0,'msg'=>'success','data'=>$filename,'progress'=>input('page').'/'.input('count')]);
        }
    }
    
    public function replaceContent(){
        if(request()->isAjax()){
            $filename = $this->view_template_path .input('filename');
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
        $filename = $this->view_template_path .input('filename');
        $str = file_get_contents($filename);
        View::assign('filecont',$str);
        return View::fetch();
    }
}
