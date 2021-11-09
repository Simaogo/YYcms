<?php
use think\facade\Route;
Route::rule('list-:tid', 'Template/list', '*')->name('list');
Route::rule('view-:aid', 'Template/view', '*')->name('view');