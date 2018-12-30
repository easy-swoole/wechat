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

#### Exception Catch
Exception for ***EasySwoole\WeChat\Exception\RequestError*** or ***EasySwoole\WeChat\Exception\OfficialAccountError*** will be throw when you exec any officialAccount action if your network was wrong or you had pass some invalid argument. So you must catch these Exception,just like :
```
use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Exception\OfficialAccountError;

try{
    $wechat->officialAccount()->ipList();
}catch (RequestError $requestError){

}catch (OfficialAccountError $error){
        
}
```

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