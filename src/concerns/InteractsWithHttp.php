<?php

namespace QianSion\Api\concerns;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

trait InteractsWithHttp
{
    protected $endpoint = "https://api.qiansion.cn/";

    protected $AppKey;
    
    protected $AppSecret;

    protected $handleStack;
    
    protected $accessToken;

    public function __construct($AppKey, $AppSecret, $handler = null)
    {
        $this->AppKey     = $AppKey;
        $this->AppSecret     = $AppSecret;
        $this->handleStack = HandlerStack::create($handler);
        $this->accessToken = self::getToken();
    }

    public function request($method, $uri = '', $options = [])
    {
        $client = $this->createHttpClient();

        $response = $client->request($method, $uri, $options);

        return $this->parseResponse($response);
    }

    protected function parseResponse(ResponseInterface $response)
    {
        $result = $response->getBody()->getContents();

        if (false !== strpos($response->getHeaderLine('Content-Type'), 'application/json')) {
            $result = json_decode($result, true);
        }

        return $result;
    }
    
    /**
     * 获取Token
     * @auth MyBos
     * @param Token
     */
    protected function getToken(){
        $client = new Client([
            'base_uri' => $this->endpoint,
            'handler'  => $this->handleStack,
            'headers'  => [],
            'verify'   => false,
        ]);
        $SendData = array(
            'service' =>"App.Auth.ApplyToken",
            'app_key' =>$this->AppKey,
            'app_secret' =>$this->AppSecret
        );
        
        $response = $client->request('POST', $this->endpoint, $SendData);
        $result = $this->parseResponse($response);
        return $result;        
    }
    /**
     * 使用CURL向短信接口发送POST数据
     * @param string       $method
     * @param string       $url
     * @param array|string $data
     * @param array        $headers
     * @param int          $timeout
     * @return bool|string
     */
    private function getCurl($method = 'GET', $url, $data, $headers = array(), $timeout = 10){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        if (!empty($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        } else {
        }
        $result = curl_exec($curl);
		//CURL返回false时打印查看
		//var_dump( curl_error($curl) );

        curl_close($curl);
        return $result;
    }

    protected function createHttpClient()
    {
        return new Client([
            'base_uri' => $this->endpoint,
            'handler'  => $this->handleStack,
            'headers'  => [
                'Authorization' => "AppKey {$this->AppKey}",
                'User-Agent'    => "QianSionApi/1.0",
            ],
            'verify'   => false,
        ]);
    }

}
