<?php
namespace app\index\controller;

class Error {
    public function __call($method, $args)
    {
        return 'error request!';
    }
}
