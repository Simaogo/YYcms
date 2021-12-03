<?php

namespace app\index\controller;
use think\facade\View;
use think\facade\Db;
use app\index\controller\Common;
use think\facade\Config;
class Template extends Common{
    
    use \app\common\controller\Jump;
    public $default;
    public $view_dir_name ;
    
    public function __construct() {
        $this->view_dir_name = Config::get('view.view_path');
    }
    /**
     * 列表页
     * @return string
     */
    public function list(){
         $typeid=input('tid')?input('tid'):input('typeid');
         if(!$typeid)$this->error('栏目不存在');//全部
         $view = cache('view_list_'.$typeid);
         if(!$view){
            $page = input('page');
            $arctypeModel = new \app\common\model\Arctype();
            $Arctype = $arctypeModel->find($typeid);
            if(!$Arctype) $this->error('栏目不存在!','/');
            $typeinfo = $Arctype ? $Arctype->toArray():array();
            $where = [];
            if($Arctype->ispart == 0){ //列表模板
                $template=$Arctype->templist;
                if(!$typeid) return '';
                $ChanneltypeModel = new \app\common\model\Channeltype();
                $Channeltype = $ChanneltypeModel->find($Arctype->channeltype);
            }
            if($Arctype->ispart == 1){ //封面模板
                $view["template"]=$Arctype->tempindex;
            } else {
                $view["template"]=$Arctype->templist;
            }
            $view = array_merge($typeinfo,$view);
            $view['title']  = $Arctype->typename;
            $view['typeurl'] = url("template/list",["tid"=>$Arctype->id])->build();
            $view['position'] = $Arctype->position($Arctype::select(),$Arctype->id);
            $view["ispart"] = $Arctype->ispart;
            cache('view_list_'.$typeid,$view);
        }
        if(request()->isPost()){//ajax 加载
             return json(['list'=>$view['list'],'page'=>$pagesize/$row]);
        }
        //模板
        $template  = str_replace('{style}/','', $view["template"]);
        $template = $this->templateDefault($template,$view['ispart'],$this->view_dir_name);
        $yy = [ 'field' => $view];
        View::assign(['yy'=>$yy]);
        return View::fetch($this->view_dir_name .''.$template);
    }
   
    /**
     * 内容页
     * @return type
     */
    public function view(){
        $aid=input('aid');
        $ArchivesModel= new \app\common\model\Arclist();
        $Archives=$ArchivesModel->find($aid);
        $view = cache('view_'.$aid);
        if(!$view){
            $ArctypeModel = new \app\common\model\Arctype();
            $Arctype = $ArctypeModel->find($Archives->typeid);
            $typeinfo = $Arctype->toArray();
            $channeltypeModel = new \app\common\model\Channeltype();
            $channeltype=$channeltypeModel->find($Arctype->channeltype);
            $table = replacePrefix($channeltype->addtable);
            $addinfo = Db::name($table)->where('aid',$aid)->find();
            $info = is_array($addinfo) ? array_merge($addinfo,$Archives->toArray()):$Archives->toArray();
            $info['body'] = isset($info['body']) ? $info['body'] :'';//兼容body 为空
            $template = $Arctype->temparticle;
            $typeurl = url("template/list",["tid"=>$Arctype->id])->build();
            $view = [
                'typeurl'     => $typeurl ,
                'position'    => $Arctype->position($ArctypeModel::select(),$Arctype->id)
            ];
            $view = array_merge($typeinfo,$view);
            $view = array_merge($view,$info);
            $view['imgurls'] = isset($view['imgurls']) && $view['imgurls'] ? \fun\Process::decode_imgurls($addinfo['imgurls']) :explode(',',$view['litpic']);//解析图集字段
            if(!is_array($view['imgurls'])) $view['imgurls'] = explode(',',$view['imgurls']);
            cache('view_'.$aid,$view); 
        }	
        $template= str_replace('{style}/','', $view['temparticle']);
        $template = $this->templateDefault($template,2,$this->view_dir_name);
        $yy = [ 'field' => $view];
        View::assign(['yy'=>$yy]);
	//点击率++
        $Archives->click=($Archives->click)+1;
         $Archives->isAutoWriteTimestamp(false)->save();
        return View::fetch($this->view_dir_name .''. $template);
    }
    public function search(){
        if(!input('q')) $this->error ("没有关键词");
        $view['title'] = '搜索结果';
        $view['typename'] = '搜索结果';
        $view['keywords'] = '搜索结果';
        $view['description'] = '搜索结果';
        $view['position'] = '搜索结果';
        $template = 'search.htm';
        $template = $this->isMobleTemplate($template);
        $yy = [ 'field' => $view];
        View::assign(['yy'=>$yy]);
         return View::fetch($this->view_dir_name .''.$template);
    }
    public function message(){
        if(request()->isPost()){
            $post = input();
            $diyid = $post['diyid'];
            if(!$diyid) $this->error ('error');
            $Diyforms = \app\common\model\Diyforms::where(['diyid'=>$diyid])->find();
            $prefix = \think\facade\Config::get('database.connections.mysql.prefix');
            $table = replacePrefix($Diyforms->table);
            $sql = 'show full columns from `'.$prefix.''.$table.'`';
            $tableParam = Db::query($sql);
            $data = [];
            foreach ($tableParam as $key =>$val){
                $name = $val['Field'];
                if($name == 'create_time'){
                    $data[$name] = time();
                } else {
                    $data[$name] = isset($post[$name]) && $post[$name] ? $post[$name] :'';
                }
            }
            unset($data['id']);
            if(Db::name($table)->save($data)){
                $this->success('提交成功');
            } else {
                $this->error('提交失败');
            }
        }
    }
    public function siteMap(){
        $template = 'sitemap';
        if(isMobile()){
            $template = 'sitemap_m';
            if(!file_exists(Config::get('view.view_path').''.$template .'.'.Config::get('view.view_suffix'))){
                $template = 'sitemap';
            }
        }
        $template .=  '.'. Config::get('view.view_suffix');
        return View::fetch(Config::get('view.view_path') .''.$template);
    }
    /**
     * 手机模板加 _m 结尾
     * @param string $templateName
     * @return string
     */
    public function isMobleTemplate($templateName){
        if(isMobile()){
            $view_suffix = Config::get('view.view_suffix');
            $arr = explode('.',$templateName);
            $templateName = $arr[0].'_m.'.$view_suffix;
            if(file_exists($templateName)){
                return $templateName;
            }
        }
      return $templateName;
    }
    /**
     * 默认模板
     * @param type $templateName
     * @param type $ispart
     * @return string
     */
    public function templateDefault($templateName,$ispart = 2){
        $view_dir_name =$this->view_dir_name;
        $config_view_suffix = Config::get('view.view_suffix');
        $view_suffix = '.'.$config_view_suffix; //模板后缀
        if(isMobile()) $view_suffix = '_m.' .$config_view_suffix; //手机模板后缀加M
        $arr = explode('.', $templateName);
        $template = $arr[0];
        $isTemplate = file_exists($view_dir_name.''.$template.''.$view_suffix);//检测模板是否存在
        if(!$isTemplate){
            if($ispart == 1){
                $template_default = 'index_default';
            } else if($ispart == 0){
                $template_default  = 'list_default';
            } else {
                $template_default  = 'article_default';
            }
            if(file_exists($view_dir_name . '' .$template_default .''.$view_suffix)){ //检测默认模板是否存在
                return $template_default .''. $view_suffix;
            }else{
                //手机默认模板不存在,重新判断PC模板是否存在
                if(file_exists($view_dir_name . $template .'.'. $config_view_suffix)) { 
                   return $template .'.'. $config_view_suffix;
                }else{
                   return  $template_default .'.'.$config_view_suffix;
                }
            }
        }
        return $template . '' . $view_suffix;
    }
}