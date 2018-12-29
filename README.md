# EasySwoole WeChat

## Example
### Get Instance
```php
use EasySwoole\WeChat\WeChat;
$wechat = new WeChat();
```
### Set Global Temp Dir
```php
$wechat->config()->setTempDir('my dir');
```

### OfficialAccount

OfficialAccount WeChat Sand Box: https://mp.weixin.qq.com/debug/cgi-bin/sandbox?t=sandbox/login

#### Init OfficialAccount Config
```php
$wechat->officialAccount()->getConfig()->setAppId('your appid')->setAppSecret('your aoo secret');
```
#### Access Token
```php
// if success return token
$wechat->officialAccount()->accessToken()->refresh();

$wechat->officialAccount()->accessToken()->getToken();
```
#### Get OfficialAccount Server List
```php
$wechat->officialAccount()->ipList()
```