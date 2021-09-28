<?php

namespace qiansion\api;

use qiansion\api\Concerns\InteractsWithHttp;
use qiansion\api\Concerns\InteractsWithRequest;
use qiansion\api\Request;

include_once __DIR__ . '/Request/Default.php';

class Client {
    use InteractsWithHttp, InteractsWithRequest;

    public function __call($method, $params){
        $file = __DIR__ . '/Request/' . $method . '.php';
        if (file_exists($file)) {
            include_once $file;
            return new Group($this, $method);
        } else {
            $Group = new Group($this);
            return (new Group($this))->{$method}(...$params);
        }
    }
}

