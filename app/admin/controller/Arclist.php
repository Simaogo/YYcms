<?php

namespace app\admin\controller;
use app\admin\model\Arclist as ArclistModel;
use app\admin\model\Arctype as ArctypeModel;
use app\admin\model\Channeltype as ChanneltypeModel;
use think\facade\View;
use think\facade\Db;
class Arclist {
    public function index(){
        if(request()->isAjax()){
            $ArclistModel = new ArclistModel();
            $page = input('page')-1;
            $limit = input('limit');
            $typeid = input('typeid');
            $where = [];
            if($typeid){
                $menu = ArctypeModel::select()->toArray();
                $ids = ArctypeModel::childrenIds($menu, $typeid);
                //降维
                $typeids = trim(array_reduce($ids, function($carry, $item){
                    return $carry . ','.$item;
                }), ',');
                $where[]= ['typeid','in',$typeids];
            }
            $list = ArclistModel::withJoin('arctype')
                    ->where($where)
                    ->limit($page,$limit)
                    ->order('id desc')
                    ->select()
                    ->toArray();
            $count = ArclistModel::where($where)->count();
            return json(['code'=>0,'msg'=>'success','data'=>$list,'count'=>$count]);
        }
        return View::fetch();
    }
    /**
     * 栏目列表
     * @return type
     */
    public function arctypeList(){
        if(request()->isAjax()){
           $ArctypeModel = new ArctypeModel();
           $data = $ArctypeModel->where('ishidden',0)->field('id,reid,typename')->select()->toArray();
           $menu = $ArctypeModel->arctypeTree($data);
           return json(['code'=>0,'msg'=>'success','data'=>$menu]);
        }
    }
    /**
     * 文章编辑
     * @return type
     */
    public function addEdit(){
        $id = input('id');
        if(request()->isAjax()){
            $post = input();
            $post['pubdate'] = $post['pubdate']?strtotime($post['pubdate']):time();
            if(!$post['litpic']&&$post['body']){ //提取内容第一张为缩略图
                $post['litpic'] = $this->get_html_first_imgurl ($post['body'])? $this->get_html_first_imgurl ($post['body']):'';
            }
            if($post['litpic']){
                if(isset($post['flag'])&&$post['flag']){
                    $post['flag'] = array_search('p',$post['flag']) == false ? array_push($post['flag'],'p'):$post['flag'];
                } else {
                    $post['flag'] =['p'];
                }
            }
            $post['click'] = isset($post['click']) && empty($post['click']) ? rand(50, 500):$post['click'];
            unset($post['tags']);////////////等完善!!!!
            unset($post['file']);
            //flag字段降维
            if(isset($post['flag'])&&$post['flag']){
                $post['flag'] = trim(array_reduce($post['flag'], function($carry, $item){
                    return $carry . ','.$item;
                }), ',');
            }
            //分离主表、附表数据
            $Arctype = ArctypeModel::find($post['typeid']);
            $post['channel'] =$Arctype->channeltype;
            $Channeltype = ChanneltypeModel::find($Arctype->channeltype);
            $table = $this->getTable($Channeltype->addtable);
            $data =$this->separation($post, $table);
           // halt($data);
            if($id){
                ArclistModel::update($data['mainData']);
                Db::name($table)->update($data['addtableData']);
            } else {
               $data['mainData']['description'] = isset($data['mainData']['description']) && empty($data['mainData']['description']) ? $this->getplaintextintrofromhtml($data['addtableData']['body']) :$data['mainData']['description'];
               //兼容id自增
               $last = ArclistModel::order('id desc')->limit(1)->select();
               $data['mainData']['id'] =($last[0]->id)+1;
               $Arclist = ArclistModel::create($data['mainData']); 
               $data['addtableData']['aid'] = $Arclist->id;
               Db::name($table)->insert($data['addtableData']);
            }
            return json(['code'=>0,'msg'=>'success']);
        }
        $view = [];
        if($id){
            $maininfo = ArclistModel::find($id);
            $maininfo['flag'] = explode(',', $maininfo['flag']);
            $channel = ChanneltypeModel::find($maininfo['channel']);//模型
            $addtable = $this->getTable($channel->addtable);
            $addinfo = Db::name($addtable)->where('aid',$id)->find();//附表信息
            if($channel->nid=='image' && isset($addinfo['imgurls']) && $addinfo['imgurls']){
                $pattern = "/ddimg='(.*)'\s+text/";
                if(preg_match($pattern, $addinfo['imgurls'])){
                    preg_match_all($pattern, $addinfo['imgurls'],$imgurls);//解析图集字段
                    $addinfo['imgurls'] =$imgurls[1];
                } else {
                    $addinfo['imgurls'] = $addinfo['imgurls'];
                }
            }
            $view['formData'] = $addinfo ? array_merge($maininfo->toArray(), $addinfo) : $maininfo;//合并
        }
        $view['typeid'] =input('typeid');
        if($view['typeid']){
           $Arctype = ArctypeModel::find($view['typeid']);
           $channel = ChanneltypeModel::find($Arctype->channeltype);//模型
           $view['fieldset'] = $channel->fieldset;//自定义字段
           $view['channeltype'] = $channel->id;//模型ID
        } else {
            $view['channeltype'] = 1;
        }
        $menu = ArctypeModel::select()->toArray();
        $view['arctypeList'] =ArctypeModel::cateTree($menu);
        View::assign($view);
        return View::fetch('add');
    }
    /**
     * del
     * @return type
     */
    public function del(){
        if(request()->isAjax()){
            $id =input('id');
            $maininfo = ArclistModel::find($id);
            $channel = ChanneltypeModel::find($maininfo['channel']);//模型
            $addtable = $this->getTable($channel->addtable);
            $addinfo = Db::name($addtable)->where('aid',$id)->delete();//del附表信息
            ArclistModel::destroy($id);
            return json(['code'=>0,'msg'=>'success']);
        }
    }
    /**
     * 分离主表和附表数据
     * @return type
     */
    public function separation($post,$table){
        $table = config('database.connections.mysql.prefix').$table;
        $lineField=Db::query("show COLUMNS FROM `$table`");
        $data=[];
        foreach ($lineField as $key=>$val){
            $fiel =$val['Field'];
            if(isset($post[$fiel])){
                $data[$fiel]=$post[$fiel];
                if($fiel!='typeid') unset($post[$fiel]);
             } else {
                  $data[$fiel]='';
             }
        }
        if(isset($post['id'])&&$post['id']) $data['aid'] =$post['id'];
       return ['addtableData'=>$data,'mainData'=>$post];
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
    /**
     * 提取内容第一张为缩略图
     * @param type $html
     * @return type string
     */
    function get_html_first_imgurl($html){
        $pattern = '/<img.*?src=[\'|\"](.+?)[\'|\"].*?>/i';
        preg_match_all($pattern, $html, $matches);//正则表达式把图片的整个都获取出来了
        $img_arr = $matches[0];//全部图片数组
        $first_img_url = "";
        if (!empty($img_arr)) {
          $first_img = $img_arr[0];
          $p="#src=('|\")(.*)('|\")#isU";//正则表达式
          preg_match_all ($p, $first_img, $img_val);

          if(isset($img_val[2][0])){
            $first_img_url = $img_val[2][0]; //获取第一张图片地址
          }
        }
        return $first_img_url;
     }
    /**
     *  从内容提取描述
     * @param type $html
     * @param type $len
     * @return string
     */
    public function  getplaintextintrofromhtml($html,$len=150) {
            if(!$html) return '';
            $html = strip_tags($html);
            $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
            $html_len = mb_strlen($html,'UTF-8');
            $html = mb_substr($html, 0, $len, 'UTF-8');
            return $html;
    }
    
}
