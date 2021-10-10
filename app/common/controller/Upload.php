<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\controller;

/**
 * Description of Upload
 *
 * @author Administrator
 */
class Upload {
    public function index(){
       
    }
    public function image(){
         $data = ['src'=>'/uploads/image/20211004/1633336916137110.jpg'];
         return json(['code'=>0,'data'=>$data,'msg'=>'success']);
    }
}
