<?php

namespace app\index\controller;
use think\facade\View;
use think\facade\Db;
use app\index\controller\Common;

class Template extends Common{
    public $default;
    public function __construct() {
        $this->default ='template/default/';
    }
    public function index(){
         $theme=$this->template('index');
         return View::fetch('../template/default/index.htm');
    }
    public function list(){
         $typeid=input('tid')?input('tid'):input('typeid');
         if(!$typeid)$this->error('栏目不存在');//全部
         $view = cache('view_list_'.$typeid);
         if(!$view){
            $page=input('page');
            $arctypeModel = new \app\common\model\Arctype();
            $Arctype = $arctypeModel->find($typeid);
            $where = [];
            if($Arctype->ispart==1){
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
                        ->order('update_time desc ,sortrank desc')
                        ->select()
                        ->toArray();
                $serializefield= explode(',', $Channeltype->serializefield);

                foreach ($list as $key=>$val){
                    foreach ($val as $k=>$v){
                        if(in_array($k,$serializefield)||$k=='flag'){
                            if($v) $list[$key][$k] = Process::decode_item($v);
                        }
                        if($k=='litpic'){
                            $list[$key][$k]= explode(',', $v);
                        }
                        if($k=='redirecturl'){
                            if($v){
                                $list[$key]['url']=$v;
                            } else {
                                $url=url('template/view', ['aid'=>$val['aid']]);
                                $list[$key]['url']= $url->build();
                            }   
                        }
                        if($k == 'title'&&$keywords) $list[$key]['title'] = preg_replace("/($keywords)/i", "<b style='color:#50b400'>".$keywords."</b>",  $list[$key]['title']);//搜索标题高亮  
                    }
                }
                $view['list'] = $list;
                $view['page'] = $page;
            }
            if($Arctype->ispart==2){
                $template=$Arctype->tempindex;
            } else {
                $template=$Arctype->templist;
            }
            $view['typename']=$Arctype->typename;
            $view['keywords']=$Arctype->keywords;
            $view['description']=$Arctype->description;
            $view["content"] = $Arctype->content;
            if(!$keywords)cache('view_list_'.$typeid,$view);
        }
        
         if(request()->isPost()){//ajax 加载
             return json(['list'=>$view['list'],'page'=>$pagesize/$row]);
         } 
        $template= str_replace('{style}/','', $template);
        View::assign($view);
        $template=$this->default . $this->template($template);
        return View::fetch($template);
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
            $Arctype=$ArctypeModel->find($Archives->typeid);
            $channeltypeModel = new \app\common\model\Channeltype();
            $channeltype=$channeltypeModel->find($Arctype->channeltype);
            $table = $this->getTable($channeltype->addtable);
            $addinfo=Db::name($table)->where('aid',$aid)->find();
            $info= array_merge($addinfo,$Archives->toArray());
            foreach ($info as $key=>$val){
                if(in_array($key, ['stay_address','repast_morning','repast_noon','repast_night','j_content','j_address'])){
                    $info[$key]=Process::decode_item($val);
                }
                if($key=='litpic'){
                     $info[$key]= explode(',', $val);
                }
            }
            $template = $Arctype->temparticle;
            $view = [
                'body' => $info,
                'typename' =>  $Arctype->typename,
                'template' => $Arctype->temparticle,
                'keywords' => $Archives->keywords,
                'description' => $Archives->description,
            ];
            cache('view_'.$aid,$view); 
        }
        $template= str_replace('{style}/','', $view['template']);
        View::assign($view);
        $template=$this->default . $this->template($template);
        return View::fetch($template);
        
    }
    public function search(){
        $getdata=input();
        $typeid=$getdata['typeid'];
        $arctypeModel = new \addons\travel\common\model\Arctype();
        $Arctype = $arctypeModel->find($typeid);
    }
    public function template($template){
        if(isMobile()){
            $arr = explode('.',$template);
            $template = $arr[0].'_m';
        }
      return $template;
    }
    public function retrieve_ids(&$ids, $record) {
        return $ids . ',' . $record['id'];
    }
    public function getdest($pid=0){
        $DestinationModel = new \app\common\model\Destination();
        $list= $DestinationModel->where('pid',$pid)
                ->select()
                ->toArray();
        $destination=$DestinationModel->destinationOrder($list);
        $Destination=$DestinationModel->find($pid);
        if(!$list){
             $list= $DestinationModel->where('pid',$Destination->pid) //没有则等于同级
                ->select()
                ->toArray();
        }
         View::assign([
            'destination' =>$list,
            'destname' =>$Destination->destination,
        ]);
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
