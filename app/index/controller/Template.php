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
        $this->view_dir_name = '../template/'. syscfg("cfg_df_style").'/';
    }
    public function list(){
         $typeid=input('tid')?input('tid'):input('typeid');
         if(!$typeid)$this->error('栏目不存在');//全部
         $view = cache('view_list_'.$typeid);
         if(!$view){
            $page=input('page');
            $arctypeModel = new \app\common\model\Arctype();
            $Arctype = $arctypeModel->find($typeid);
            if(!$Arctype) $this->error('栏目不存在!','/');
            $typeinfo = $Arctype ? $Arctype->toArray():array();
            $where = [];
            if($Arctype->ispart==0){ //列表模板
                $template=$Arctype->templist;
                $row=10;
                if(!$typeid) return '';
                $pagesize=0;
                if ($page) $pagesize=$page*$row-$row;
                $ChanneltypeModel = new \app\common\model\Channeltype();
                $Channeltype = $ChanneltypeModel->find($Arctype->channeltype);
                //标题搜索
                $keywords=trim(input('keywords'),' ');
                if($keywords){
                    $where[]=['arc.title','like','%'.$keywords .'%'];
                }
                //栏目下级ID
                $chinldIds=$arctypeModel->where('reid',$typeid)->field('id')->select()->toArray();
                $typeids=trim(array_reduce($chinldIds,function($cid,$chi){
                    return $cid.','.$chi['id'];
                }),',');
                $typeids=$typeids?$typeid.','.$typeids:$typeid;
                $where[]=['arc.typeid','in',$typeids];
                $page = Db::name('archives')->alias('arc')
                        ->where($where)
                        ->join($Channeltype->addtable.' add','arc.id=add.aid','left')
                        ->paginate(['list_rows'=>$row,'query' =>['tid'=>$typeid]]);
                $page = $page->render();
                $list = Db::name('archives')->alias('arc')
                        ->where($where)
                        ->join($Channeltype->addtable.' add','arc.id=add.aid','left')
                        ->limit($pagesize,$row)
                        ->order('sortrank desc,pubdate desc')
                        ->select()
                        ->toArray();
                $serializefield= explode(',', $Channeltype->serializefield);
                foreach ($list as $key=>$val){
                    foreach ($val as $k=>$v){
//                        if(in_array($k,$serializefield)||$k=='flag'){
//                            if($v) $list[$key][$k] = Process::decode_item($v);
//                        }
                        if($k=='litpic'){
                            $list[$key][$k]= explode(',', $v);
                        }
                        if($k=='redirecturl'){
                            if($v){
                                $list[$key]['url']=$v;
                            } else {
                                $url = url('template/view', ['aid'=>$val['aid']]);
                                $list[$key]['url']= $url->build();
                            }   
                        }
                        if($k == 'title'&&$keywords) $list[$key]['title'] = preg_replace("/($keywords)/i", "<b style='color:#50b400'>".$keywords."</b>",  $list[$key]['title']);//搜索标题高亮  
                    }
                }
                //$view['list'] = $list;
               // $view['page'] = $page;
            }
            if($Arctype->ispart == 1){ //封面模板
                $view["template"]=$Arctype->tempindex;
            } else {
                $view["template"]=$Arctype->templist;
            }
            $view['typeurl'] = Config::get('app.list_url') . '/tid/' . $Arctype->id;
            $view['position'] = '<a href="/">首页</a>' . syscfg('cfg_list_symbol') .$Arctype->typename;
            $view = array_merge($typeinfo,$view);
           // halt($view);
            //cache('view_list_'.$typeid,$view);
        }
        if(request()->isPost()){//ajax 加载
             return json(['list'=>$view['list'],'page'=>$pagesize/$row]);
        }
        //模板
        $template = !isset($view["template"]) ? cache('template'):$view["template"];  
        $ispart = !isset($view["ispart"]) ? cache('ispart'):$view["ispart"];  
        $template  = str_replace('{style}/','', $template);
        $template = $this->isMobleTemplate($template);
        $template = $this->templateDefault($template,$ispart,$this->view_dir_name);
       //  halt($view);
        View::assign(['info'=>$view]);
        return View::fetch($this->view_dir_name .''.$template);
    }
    public function view(){
        $aid=input('aid');
        $ArchivesModel= new \app\common\model\Arclist();
        $Archives=$ArchivesModel->find($aid);
        //点击率++
        $Archives->click=($Archives->click)+1;
        $Archives->save();
        $view = cache('view+'.$aid);
        if(!$view){
            $ArctypeModel = new \app\common\model\Arctype();
            $Arctype = $ArctypeModel->find($Archives->typeid);
            $typeinfo = $Arctype->toArray();
            $channeltypeModel = new \app\common\model\Channeltype();
            $channeltype=$channeltypeModel->find($Arctype->channeltype);
            $table = $this->getTable($channeltype->addtable);
            $addinfo=Db::name($table)->where('aid',$aid)->find();
            $info= array_merge($addinfo,$Archives->toArray());
            foreach ($info as $key=>$val){
                if($key=='litpic'){
                     $info[$key]= explode(',', $val);
                }
            }
            $template = $Arctype->temparticle;
            $view = [
                'typeurl'     =>Config::get('app.list_url') . '/tid/' . $Arctype->id,
                'position'    => '<a href="/">首页</a> '. syscfg('cfg_list_symbol') .''. $Arctype->typename
            ];
            $view = array_merge($typeinfo,$view);
            $view = array_merge($view,$info);
            cache('view_'.$aid,$view); 
        }
        $template= str_replace('{style}/','', $view['temparticle']);
        $template = $this->isMobleTemplate($template);
        $template = $this->templateDefault($template,2,$this->view_dir_name);
        View::assign(['info'=>$view]);
        return View::fetch($this->view_dir_name .''. $template);
    }
    public function search(){
        $template = $this->isMobleTemplate($template);
         return View::fetch($this->view_dir_name .''.$template);
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
    public function templateDefault($templateName,$ispart = 2,$view_dir_name){
       $view_suffix = Config::get('view.view_suffix');
       $isTemplate = file_exists($view_dir_name.''.$templateName);
        if(!$isTemplate){
            $arr = explode('.', $templateName);
            if(isMobile()) $view_suffix = '_m.' .$view_suffix;
            if($ispart == 1){
                $template = 'index_default' . $view_suffix;
            } else if($ispart == 0){
                $template  = 'list_default' . $view_suffix;
            } else {
                $template  = 'article_default' . $view_suffix;
            }
            if(isMobile()) $templateName = file_exists($view_dir_name . '' .$template) ? $template : str_replace ('_m', '', $templateName);
        }
        return $templateName;
    }
   
    /**
     * 数据表名称
     * @param type $table
     * @return type string
     */
    public function getTable($table){
        $prefix = config('database.connections.mysql.prefix'); //数据库前缀
        $table = str_replace($prefix, '', $table);//替换表名称前缀
        return $table;
    }
}
