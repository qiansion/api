<?php

namespace qiansion\tests;

use PHPUnit\Framework\TestCase;
use qiansion\api\Client;

class ClientTest extends TestCase
{
    public function testApi()
    {
        $client = new Client('AppCode', 'AppSecret');

        $result = $client->resolveApi('CheckApi/Status', 'POST')
        //    ->withOrderNo('OrderNo')  //需要传参的时候在此设置
            ->request();

        var_dump($result);
    }
}
