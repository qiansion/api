<?php

namespace QianSion\Api;

use QianSion\Api\Concerns\InteractsWithHttp;
use QianSion\Api\Concerns\InteractsWithRequest;

include_once __DIR__ . '/Request/Default.php';

class Client {
    use InteractsWithHttp, InteractsWithRequest;

    public function __call($method, $params){
        $file = __DIR__ . '/Request/' . $method . '.php';
        if (file_exists($file)) {
            include_once $file;
            return new Group($this, $method);
        } else {
            return (new Group($this))->{$method}(...$params);
        }
    }
}
