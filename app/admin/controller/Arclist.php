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
    
    public function arctypeList(){
        if(request()->isAjax()){
           $ArctypeModel = new ArctypeModel();
           $data = $ArctypeModel->where('ishidden',0)->field('id,reid,typename')->select()->toArray();
           $menu = $ArctypeModel->arctypeTree($data);
           return json(['code'=>0,'msg'=>'success','data'=>$menu]);
        }
    }
    
    public function addEdit(){
        $id = input('id');
        if(request()->isAjax()){
            $post = input();
            $post['pubdate'] = $post['pubdate']?strtotime($post['pubdate']):time();
            unset($post['tags']);
            unset($post['file']);
            //flag字段降维
            if(isset($post['flag'])&&$post['flag']){
                $post['flag'] = trim(array_reduce($post['flag'], function($carry, $item){
                    return $carry . ','.$item;
                }), ',');
            }
            //分离主表、附表数据
            $Arctype = ArctypeModel::find($post['typeid']);
            $Channeltype = ChanneltypeModel::find($Arctype->channeltype);
            $table = $this->getTable($Channeltype->addtable);
            $data =$this->separation($post, $table);
            if($id){
                ArclistModel::update($data['mainData']);
                Db::name($table)->update($data['addtableData']);
            } else {
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
            $view['formData'] = array_merge($maininfo->toArray(),$addinfo);//合并
        }
        $menu = ArctypeModel::select()->toArray();
        $view['arctypeList'] =ArctypeModel::cateTree($menu);
        View::assign($view);
        return View::fetch('add');
    }
    
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
}
