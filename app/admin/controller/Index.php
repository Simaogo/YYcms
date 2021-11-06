<?php
declare (strict_types = 1);

namespace app\admin\controller;
use think\facade\View;
use think\facade\Config;
use app\common\controller\Backend;

class Index extends \app\common\controller\Backend
{
    
    public function index(){
        View::layout(false); 
        $view = [
            'admin' => session('admin')
        ];
        View::assign($view);
        return View::fetch('index'); 
    }
    public function console(){
        return View::fetch(); 
    }
    public function home()
    {
        $version = \think\facade\Db::query('SELECT VERSION() AS ver');
        $view = [
            'url' => $_SERVER['HTTP_HOST'],
            'document_root' => $_SERVER['DOCUMENT_ROOT'],
            'document_protocol' => $_SERVER['SERVER_PROTOCOL'],
            'server_os' => PHP_OS,
            'server_port' => $_SERVER['SERVER_PORT'],
            'server_ip' => $_SERVER['REMOTE_ADDR'],
            'server_soft' => $_SERVER['SERVER_SOFTWARE'],
            'server_file' => $_SERVER['SCRIPT_FILENAME'],
            'php_version' => PHP_VERSION,
            'mysql_version' => $version[0]['ver'],
            'auth' => '0',
            'now_version' => Config::get('app.version')
        ];
        View::assign($view);
        return View::fetch('home'); 
    }
    public function install()
    {
        if (request()->isAjax()) {
            $url = 'http://ylcms.gzdkrj.com/version/';
            $version = json_decode(file_get_contents($url.'version.json'));
            $rootPath = root_path();
            if($version->version!==Config::get('app.version')){
                $versionUrl = $url.$version->version.'.zip';
                $content = file_get_contents($versionUrl);
                $filename =$version->version;
                $fileDir = $rootPath.'/runtime/upgrade/';
                if (!is_dir($fileDir)) {
                    \fun\helper\FileHelper::mkdirs($fileDir);
                }
                $fileName = $fileDir . $filename . '.zip';
                @touch($fileName);
                file_put_contents($fileName, $content);
                \fun\helper\ZipHelper::unzip($fileName, $file = $fileDir . $filename . '/');
                $dir = scandir($fileDir . $filename . '/');
                try {
                    foreach ($dir as $k => $v) {
                        if ($v == '.' || $v == '..') continue;
                        $file = $fileDir . $filename . '/' . $v;
                        if ($v == 'upgrade.sql') {
                            importSqlData($file);
                        } else if (is_file($file)){
                            @copy($file,$rootPath .$v);
                        }else{
                            \fun\helper\FileHelper::copyDir($file, $rootPath . $v);
                        }
                    }
                }catch (\Exception $e){
                    $this->error($e->getMessage());
                }
                @unlink($fileName);
                \fun\helper\FileHelper::delDir($fileDir . $filename);
                setConfig($rootPath . '/config/app.php','version',$filename);
                return json(['code'=>0,'msg'=>'success']);
            } else {
                return json(['code'=>0,'msg'=>'已经是最新版本!!!!']);
            }   
        }
    }
    public function clear(){
        if(request()->isAjax()){
            \fun\helper\FileHelper::delDir(root_path().'runtime');
             return json(['code'=>0,'msg'=>'success']);
        }
    } 
}
