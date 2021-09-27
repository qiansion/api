<?php

namespace qiansion\tests;

use PHPUnit\Framework\TestCase;
use qiansion\api\Client;

class ClientTest extends TestCase
{
    public function testApi()
    {
        $client = new Client('AppCode');

        $result = $client->kuaidiIndex()
            ->withOrderNo('OrderNo')
            ->request();

        var_dump($result);
    }
}
