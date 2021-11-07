<?php
use think\facade\Route;
Route::get('list', '\app\index\controller\Template@list');
Route::get('view', '\app\index\controller\Template@view');