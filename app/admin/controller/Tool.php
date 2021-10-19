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
            //处理标签内function
            $str = preg_replace('/function=\'.*\'/i','',$str);
            $str = preg_replace("/function=\".*\"/i",'',$str);
            //替换配置字段
            $str = preg_replace("/{dede:global.(\w+)\/}/i","{:syscfg('$1')}",$str); 
            //替换友情链接标签 
            $str = preg_replace("/\[field:link\s+\/\]/i",'<a href="{$field.url}" target="_blank">{$field.webname}</a>',$str);
            //替换包含文件
            $str = preg_replace('/{dede:include\s+filename="(.*).htm"\/}/i','{include file="$1"/}',$str);
            //列表页字段
            $str = preg_replace("/{dede:field\s+name='(.*)'\/}/i",'{$field.$1}',$str);
            $str = preg_replace("/{dede:field name=\"(.*)\"\/}/i",'{$field.$1}',$str);
            $str = preg_replace("/{dede:field\s+name=(\w+)\/}/i",'{$field.$1}',$str);
            
            $str = preg_replace('/{dede:field.(\w+)\s+\/}/i','{$info.$1}',$str);
    
            
            //内容页字段
            $str = preg_replace('/{dede:field.(\w+)\s+\/}/i','{$info.$1}',$str);
            $str = preg_replace('/{dede:field.(\w+)\\/}/i','{$info.$1}',$str);
            //$str = str_replace('<script src="{$field.phpurl\'/}/count.php?view=yes&aid={dede:field name=\'id\'/}&mid={dede:field name=\'mid}" type=\'text/javascript\' language="javascript"></script>','{$info.click}',$str);
            //字段处理
            $str = preg_replace("/\[field:(\w+)\/]/i", '{$field.$1}', $str);
            $str = preg_replace("/\[field:(\w+)\s+\/]/i", '{$field.$1}', $str);
            $str = preg_replace("/currentstyle=\".*\"/i", 'currentstyle="active"', $str);
            $str = str_replace("dede:","yycms:",$str);
            
            //搜索
            $list_url = config('app.list_url');
            $str = preg_replace("/\/plus\/search.php/i", $list_url.'/search', $str);
            //特殊字符串
            $str = preg_replace("/typeid=(\d+)\s+/i", 'typeid="$1" ', $str);
            $str = preg_replace("/typeid=(\d+)/i", 'typeid="$1" ', $str);
            $str = preg_replace("/titlelen=(\d*)\s/i", 'titlelen="$1" ', $str);
            $str = preg_replace("/channelid=(\d*)\s/i", 'channelid="$1" ', $str);
            $str = preg_replace("/row=(\d*)\s/i", 'row="$1" ', $str);
            $str = preg_replace("/info.content}/i", 'info.content|raw}', $str);
            $str = preg_replace("/info.body}/i", 'info.body|raw}', $str);
            $str = preg_replace("/info.position}/i", 'info.position|raw}', $str);
            $str = preg_replace("/channel\s+type=(\w+)\s+/i", 'channel type="$1" ', $str);
            
            
            $str = preg_replace("/field.pic}/i", 'field.picname}', $str);
            $str = preg_replace("/field.fulltitle}/i", 'field.title}', $str);
            $str = preg_replace("/field.infos}/i", 'field.info}', $str);
            
           
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
