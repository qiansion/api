<?php

namespace qiansion\api;

use qiansion\api\concerns\InteractsWithHttp;
use qiansion\api\concerns\InteractsWithRequest;

include_once __DIR__ . '/request/default.php';

class Client
{
    use InteractsWithHttp, InteractsWithRequest;

    public function __call($method, $params)
    {
        $file = __DIR__ . '/request/' . $method . '.php';
        if (file_exists($file)) {
            include_once $file;
            return new Group($this, $method);
        } else {
            return (new Group($this))->{$method}(...$params);
        }
    }
}
