## Example
```php
use EasySwoole\WeChat\WeChat;
$wechat = new WeChat();
```
### Set Global Temp Dir
```php
$wechat->config()->setTempDir('my dir');
```
### Init OfficialAccount Config
```php
$wechat->officialAccount()->getConfig()->setAppId('your appid')->setAppSecret('your aoo secret');
```
### Access Token
```php
// if success return token
$wechat->officialAccount()->accessToken()->refresh();

$wechat->officialAccount()->accessToken()->getToken();
```

## WeChat Sand Box
http://mp.weixin.qq.com/debug/cgi-bin/sandbox?t=sandbox/login
