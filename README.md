# EasySwoole WeChat

[![Latest Stable Version](https://poser.pugx.org/easyswoole/wechat/v/stable)](https://packagist.org/packages/easyswoole/wechat)
[![Total Downloads](https://poser.pugx.org/easyswoole/wechat/downloads)](https://packagist.org/packages/easyswoole/wechat)
[![Latest Unstable Version](https://poser.pugx.org/easyswoole/wechat/v/unstable)](https://packagist.org/packages/easyswoole/wechat)
[![License](https://poser.pugx.org/easyswoole/wechat/license)](https://packagist.org/packages/easyswoole/wechat)
[![Monthly Downloads](https://poser.pugx.org/easyswoole/wechat/d/monthly)](https://packagist.org/packages/easyswoole/wechat)

`EasySwoole WeChat 1.2.x` 是一个基于 `Swoole 4.x` 全协程支持的微信 `SDK` 库，告别同步阻塞，轻松编写高性能的微信公众号/小程序/开放平台业务接口

## 文档说明

- [组件安装](docs/install.md)
- [公众号组件文档](docs/officialAccount.md)
- [小程序组件文档](docs/miniProgram.md)

## 获取实例

在开始操作之前需要先获取一个实例，后续操作均使用该实例进行操作

```php
<?php
use EasySwoole\WeChat\WeChat;
use EasySwoole\WeChat\Config;

$wechat = new WeChat(); // 创建一个实例
$wechat->config()->setTempDir(EASYSWOOLE_TEMP_DIR); // 指定全局临时目录
```

## 异常捕获

在调用方法时，如果传递了无效的参数或者发生网络异常，将会抛出 ***\EasySwoole\WeChat\Exception\RequestError*** 或者 ***\EasySwoole\WeChat\Exception\OfficialAccountError*** 类型的异常，开发者需要手动捕获该类异常进行处理，类似如下这样：

```php
<?php
use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Exception\OfficialAccountError;

try {
    $wechat->officialAccount()->ipList();
} catch (RequestError $requestError){
   
} catch (OfficialAccountError $error){
           
}
```

## 微信公众号

微信公众号沙箱: [https://mp.weixin.qq.com/debug/cgi-bin/sandbox?t=sandbox/login](https://mp.weixin.qq.com/debug/cgi-bin/sandbox?t=sandbox/login)
