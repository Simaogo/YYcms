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
            //m替换
            $str = preg_replace('/href="\/m"/i', 'href="/"', $str);
            $str = preg_replace('/href=\'\/m\'/i', 'href="/"', $str);
            //高亮替换
            $str = preg_replace("/currentstyle=\".*\"}/i", 'currentstyle="active"}', $str);
            $str = preg_replace("/currentstyle='.*'}/i", 'currentstyle="active"}', $str);
            //详情页点击
             $str = preg_replace('/<script\s+src="{dede:field\s+name=\'phpurl\'\/}.*type=\'text\/javascript\'\s+language="javascript"><\/script>/si','{$yy.field.click}',$str);
             $str = preg_replace('/<script\s+src="{dede:field\s+name="phpurl"\/}.*type=\'text\/javascript\'\s+language="javascript"><\/script>/si','{$yy.field.click}',$str);
            //处理标签内function
            $str = preg_replace('/function=\'.*\'\/}/i','/}',$str);
            $str = preg_replace("/function=\".*\"\/}/i",'/}',$str);
            $str = preg_replace('/function=\'.*\'\/]/i','/]',$str);
            $str = preg_replace("/function=\".*\"\/]/i",'/]',$str);
            
            //替换配置字段
            $str = preg_replace("/{dede:global\.(\w+_\w+)\/}/i","{:syscfg('$1')}",$str); 
            $str = preg_replace("/{dede:global\.(\w+)\/}/i","{:syscfg('$1')}",$str); 
           
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
            $str = preg_replace("/{dede:field\s+name=\"description\"\/}/i",'{$yy.field.description}',$str);
            $str = preg_replace("/{dede:field\s+name='description'\/}/i",'{$field.description}',$str);
            $str = preg_replace("/{dede:field\s+name='description'\s+\/}/i",'{$field.description}',$str);
            $str = preg_replace("/{dede:field\s+name='description'\s+\/}/i",'{$field.description}',$str);
            $str = preg_replace("/content=\"{.*field.description}\"/i",'content="{$yy.field.description}"',$str);
            $str = preg_replace('/content=\'{.*field.description}\'/i','content="{$yy.field.description}"',$str);
            //位置字段替换
           
            //列表页字段
            $str = preg_replace("/{dede:field\s+name='(\w+)'\/}/i",'{$field.$1}',$str);
            $str = preg_replace("/{dede:field\s+name=\"(\w+)\"\/}/i",'{$field.$1}',$str);
             $str = preg_replace("/{dede:field\s+name='(\w+)'\s+\/}/i",'{$field.$1}',$str);
            $str = preg_replace("/{dede:field\s+name=\"(\w+)\"\s+\/}/i",'{$field.$1}',$str);
            $str = preg_replace("/{dede:field\s+name=(\w+)\/}/i",'{$field.$1}',$str);

            $str = preg_replace("/{dede:field.(\w+)\/}/i",'{$yy.field.$1}',$str);
            $str = preg_replace('/{dede:field.(\w+)\s+\/}/i','{$yy.field.$1}',$str);

            //内容页字段
            $str = preg_replace('/{dede:field.(\w+)\/}/i','{$field.$1}',$str);
            $str = preg_replace('/{dede:field.(\w+)\s+\/}/i','{$field.$1}',$str);
            $str = preg_replace('/{dede:field.(\w+)\/}/i','{$field.$1}',$str);
            //字段处理
            $str = preg_replace("/\[field:(\w+)\/]/i", '{$field.$1}', $str);
            $str = preg_replace("/\[field:(\w+)\s+\/]/i", '{$field.$1}', $str);
            
           // $str = str_replace("dede:","yycms:",$str);
            $str = str_replace("dede:channel","yycms:channel",$str);
            $str = str_replace("dede:sql","yycms:channel",$str);
            $str = str_replace("dede:channelartlist","yycms:list",$str);
            $str = str_replace("dede:list","yycms:list",$str);
            $str = str_replace("dede:arclist","yycms:arclist",$str);
            $str = str_replace("dede:type","yycms:type",$str);
            $str = str_replace("dede:flink","yycms:flink",$str);
            $str = str_replace("dede:flink","yycms:flink",$str);
            $str = str_replace("dede:pagelist","yycms:pagelist",$str);
            $str = str_replace("dede:prenext","yycms:prenext",$str);
            $str = str_replace("dede:tag","yycms:tag",$str);
            //搜索
            $list_url = config('app.list_url');
            $str = preg_replace("/\/plus\/search.php/i", '{:url(\'template/search\')}', $str);
            $str = preg_replace("/\/plus\/search.*\.php/i", '{:url(\'template/search\')}', $str);
            $str = preg_replace("/\/plus\/diy.php/i", '{:url(\'template/message\')}', $str);
            //特殊字符串
            $str = preg_replace("/typeid=(\d+)\s+/i", 'typeid="$1" ', $str);
            $str = preg_replace("/typeid=(\d+)/i", 'typeid="$1" ', $str);
            $str = preg_replace("/titlelen=(\d*)\s/i", 'titlelen="$1" ', $str);
            $str = preg_replace("/channelid=(\d*)\s/i", 'channelid="$1" ', $str);
            $str = preg_replace("/row=(\d*)\s/i", 'row="$1" ', $str);
            $str = preg_replace("/pagesize=(\d+)/i", 'pagesize="$1" ', $str);
            $str = preg_replace("/{(.*)field.content}/i", '{$1field.content|raw}', $str);
            $str = preg_replace("/{(.*)field.body}/i", '{$1field.body|raw}', $str);
            $str = preg_replace("/{(.*)yy.field.currentstyle}/i", '{$1field.currentstyle}', $str);
            $str = preg_replace("/{(.*)field.position}/i", '{$1yy.field.position|raw}', $str);
            //标签类型
            $str = preg_replace("/channel\s+type=(\w+)\s+/i", 'channel type="$1" ', $str);
            $str = preg_replace("/field.typedir}/i", 'field.typeurl}', $str);
            $str = preg_replace("/field.pic}/i", 'field.picname}', $str);
            $str = preg_replace("/field.fulltitle}/i", 'field.title}', $str);
            $str = str_replace("dede:productimagelist","yycms:productimagelist",$str);
            $str = str_replace("dede:myppt","yycms:myppt",$str);
            $str = str_replace("dede:hotwords","yycms:hotwords",$str);
            
            $str = str_replace('typelink', 'typeurl', $str);
            $str = str_replace("{:syscfg('cfg_cmspath')}", '', $str);
            $str = str_replace("{\$field.typeid}", '{$yy.field.typename}', $str);
             $str = str_replace("{\$field.typeid}", '{$yy.field.typename}', $str);
            //搜索显示结果
            $str = preg_replace("/{dede:global\s+name='keyword'\s+\/}/i", '{:input(\'q\')}', $str);
            $str = preg_replace("/{dede:global\s+name=\"keyword\"\s+\/}/i", '{:input(\'q\')}', $str);
           
             //手机端标签替换
            $str = preg_replace("/href=\"list.php\?tid={.*field.id}\"\s+/i", 'href="{$field.typeurl}" ', $str);
            $str = preg_replace('/href=\'list.php\?tid={.*field.id}\'\s+/i', 'href="{$field.typeurl}" ', $str);
            $str = preg_replace("/href=\"view.php\?aid={.*field.id}\"\s+/i", 'href="{$field.arcurl}" ', $str);
            $str = preg_replace('/href=\'view.php\?aid={.*field.id}\'\s+/i', 'href="{$field.arcurl}" ', $str);
            
            $str = preg_replace("/href=\"list.php\?tid={.*}\"/i", 'href="{$field.typeurl}" ', $str);
            $str = preg_replace('/href=\'list.php\?tid={.*}\'/i', 'href="{$field.typeurl}" ', $str);
            $str = preg_replace("/href=\"view.php\?aid={.*}\"/i", 'href="{$field.arcurl}" ', $str);
            $str = preg_replace('/href=\'view.php\?aid={.*}\'/i', 'href="{$field.arcurl}" ', $str);
            
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
