<?php

namespace app\admin\controller;
use app\admin\model\Arclist as ArclistModel;
use app\admin\model\Arctype as ArctypeModel;
use app\admin\model\Channeltype as ChanneltypeModel;
use think\facade\View;
use think\facade\Db;
class Arclist extends \app\common\controller\Backend{
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
           $data = $ArctypeModel->field('id,reid,typename')->select()->toArray();
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
            if($id){
                ArclistModel::update($data['mainData']);
                Db::name($table)->update($data['addtableData']);
            } else {
               $data['mainData']['description'] = isset($data['mainData']['description']) && empty($data['mainData']['description']) ? \fun\Process::getplaintextintrofromhtml($data['addtableData']['body']) :$data['mainData']['description'];
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
                $addinfo['imgurls'] = \fun\Process::decode_imgurls($addinfo['imgurls']);//解析图集字段
            }
            $view['formData'] = $addinfo ? array_merge($maininfo->toArray(), $addinfo) : $maininfo;//合并
        }
        $view['typeid'] =input('typeid');
        if($view['typeid']){
           $Arctype = ArctypeModel::find($view['typeid']);
           $channeltype = $Arctype->channeltype;
        } else {
            $channeltype = 1;
        }
        $Channel = ChanneltypeModel::find($channeltype);//模型
        $view['fieldset'] = $Channel->fieldset ?$this->decodeFileset($Channel->fieldset):'';//自定义字段
        //halt($view['fieldset']);
        $menu = ArctypeModel::select()->toArray();
        $view['arctypeList'] =ArctypeModel::cateTree($menu);
        $view['channeltype'] = $channeltype;//模型ID
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
     * 解析自定义字段为数组
     * @param type $fielsetstr
     * @return array
     */
    public function decodeFileset($fielsetstr){
        if (!$fielsetstr) return '';
        $fielsetList = explode('<field:',$fielsetstr);
        $fielset = [];
        foreach ($fielsetList as $key => $val){
                if($val){
                    $val = preg_replace('/\/>/si', '', $val);
                    $fieldsetArr = explode(' ', $val);
                    $listarr = [];
                    foreach ($fieldsetArr as $k => $v){
                        if($v){
                            if($k == 0) {
                                $listarr['name'] = $v;
                            } else {
                                $arr = explode('=',$v);
                                if(count($arr)>1) {
                                    $listarr[$arr[0]] = trim($arr[1],'"');
                                }
                            }
                        }
                    }
                    $fielset[] =$listarr;  
                }
        }
        return $fielset;
    }
    
}
