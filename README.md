# QianSion Api SDK For PHP

## `QianSionAPI`

`QianSionAPI`是`QianSion`官方推出的统一`API`接口服务，提供接口调用服务及开发`SDK`，旨在帮助开发者更方便的调用官方提供的各类`API`接口及服务。


## 安装依赖

如果已在系统上[全局安装 Composer](https://getcomposer.org/doc/00-intro.md#globally) ，请直接在项目目录中运行以下内容来安装 QianSionApi SDK For PHP 作为依赖项：
```
composer require qiansion/qiansion-api
```


## 快速使用

以【快递】查询接口为例

~~~
use qiansion\api\Client;

$client = new Client("YourAppKey", "YourAppSecret");

$result = $client->redirectUri('KuaiDi/Query', 'POST')
    ->withOrderNo('快递单号')
    ->request();
~~~

$result = $client->redirectUri('IP/getInfo', 'POST')
    ->withip('114.114.114.114')
    ->request();
~~~

所有的接口服务和方法都支持IDE自动提示和完成（请务必注意方法大小写必须保持一致），基本上不需要文档即可完成接口开发工作，所有的API调用服务必须设置`AppKey`和`AppSecret`值（注意，请勿泄露），用于接口调用的鉴权认证。

`AppKey`和`AppSecret`的值可以在[官方](https://www.qiansion.cn/)获取到，每个账号可以根据实际情况建立多个应用。

该SDK服务仅支持官方已经接入的API接口，接口数量将逐步增加，你可以告诉我们你需要的API接口，我们将视情况进行新增接口接入。

## 返回数据

`QianSionApi`所有的接口返回数据为`JSON`格式，通用规范如下：

| 名称 | 类型 | 说明 |
| --- | --- | --- |
| code | int | 返回码,200 表示成功 其它表示失败 |
| message| string | 返回提示信息 |
| data| object | 返回数据 |

## 鸣谢

特别鸣谢`ThinkAPI`的优秀设计思路。

## 版权信息

本项目遵循 Apache-2.0 开源协议发布。