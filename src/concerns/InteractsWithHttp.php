<?php

namespace qiansion\api\concerns;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;
use think\facade\Cache;

trait InteractsWithHttp
{
    protected $ApiUrl = "https://api.qiansion.cn/";

    protected $AppKey;
    
    protected $AppSecret;
    
    protected $accessToken;

    protected $handleStack;

    public function __construct($AppKey, $AppSecret, $handler = null)
    {
        $this->AppKey       = $AppKey;
        $this->AppSecret    = $AppSecret;
        $this->accessToken  = self::getAccessToken();
        $this->handleStack  = HandlerStack::create($handler);
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
    protected function getAccessToken(){
        $AccessTokenCache = Cache::get('QianSionApiAccessToken');
        if(empty($AccessTokenCache)){
            $client =  new Client();
            $response = $client->request('POST', $this->ApiUrl."Auth/Token", [
                'form_params' => [
                    'app_key' =>$this->AppKey,
                    'app_secret' =>$this->AppSecret
                ],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ]
            ]);
            $result = $this->parseResponse($response);
            $accessToken = $result['data']['access_token'];
            $expires_in = $result['data']['expires_in'];
            Cache::set('QianSionApiAccessToken', $accessToken, $expires_in - 30);
        }else{
            $accessToken = $AccessTokenCache;
        }
        return $accessToken;        
    }

    protected function createHttpClient()
    {
        return new Client([
            'base_uri' => $this->ApiUrl,
            'handler'  => $this->handleStack,
            'headers'  => [
                'Authorization' => "{$this->accessToken}",
                'User-Agent'    => "QianSionApi/2.1",
            ],
            'verify'   => false,
        ]);
    }

}
