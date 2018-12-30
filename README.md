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
$wechat->officialAccount()->getConfig()->setAppId('your appid')->setAppSecret('your aoo secret')->setToken('your token');
```

#### Server(ParserRequest)
```
use EasySwoole\WeChat\WeChat;
use EasySwoole\WeChat\Bean\OfficialAccount\AccessCheck;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestMsg;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestedReplyMsg;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;
$wechat = new WeChat();
$wechat->officialAccount()->getConfig()
    ->setAppId('setAppId')
    ->setAppSecret('setAppSecret')
    ->setToken('setToken');

/*
 * will call for every request ,if you return false means break up the process,
 * if return an RequestedReplyMsg means break up the process but also reply the msg,
 * if none return ,continue the process
 */

$wechat->officialAccount()->server()->preCall(function (RequestMsg $msg){
//    var_dump($msg->__toString());
});

/*
 * if user send test msg
 */
$wechat->officialAccount()->server()->onMessage()->set('test',function (RequestMsg $msg){
    $reply = new RequestedReplyMsg();
    $reply->setMsgType(RequestConst::MSG_TYPE_TEXT);
    $reply->setContent('hello from server');
    return $reply;
});

$wechat->officialAccount()->server()->onMessage()->set(RequestConst::DEFAULT_ON_MESSAGE,function (RequestMsg $msg){
    $reply = new RequestedReplyMsg();
    $reply->setMsgType(RequestConst::MSG_TYPE_TEXT);
    $reply->setContent('you say :'.$msg->getContent());
    return $reply;
});

$wechat->officialAccount()->server()->onEvent()->onSubscribe(function (RequestMsg $msg){
    var_dump("{$msg->getFromUserName()} has SUBSCRIBE");
    $reply = new RequestedReplyMsg();
    $reply->setMsgType(RequestConst::MSG_TYPE_TEXT);
    $reply->setContent('Welcome to EasySwoole');
    return $reply;
});

$wechat->officialAccount()->server()->onEvent()->onUnSubscribe(function (RequestMsg $msg){
    var_dump("{$msg->getFromUserName()} has UBSCRIBE");
});

$wechat->officialAccount()->server()->onEvent()->set(RequestConst::DEFAULT_ON_EVENT,function (){
    $reply = new RequestedReplyMsg();
    $reply->setMsgType(RequestConst::MSG_TYPE_TEXT);
    $reply->setContent('this is event default reply');
    return $reply;
});

$http = new swoole_http_server("127.0.0.1", 9501);
$http->on("request", function ($request, $response)use($wechat){
    if($request->server['request_method'] == 'GET'){
        $bean = new AccessCheck($request->get);
        $verify = $wechat->officialAccount()->server()->accessCheck($bean);
        if($verify){
            $response->write($bean->getEchostr());
        }
    }else{
        $res = $wechat->officialAccount()->server()->parserRequest($request->rawContent());
        if(is_string($res)){
            $response->write($res);
        }
    }
    $response->end();
});
$http->start();
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

#### NetWork Check
```php
use EasySwoole\WeChat\Bean\OfficialAccount\NetCheckRequest;
$req = new NetCheckRequest();
$wechat->officialAccount()->netCheck($req);
```

#### QrCode
```php
namespace EasySwoole\WeChat;

use EasySwoole\WeChat\Bean\OfficialAccount\QrCodeRequest;
$qrRequest = new QrCodeRequest;
$qrRequest->setActionName($qrRequest::QR_LIMIT_SCENE);
$qrRequest->setSceneId(1);

$qrCode = $wechat->officialAccount()->qrCode();
$tick = $qrCode->getTick($qrRequest);
$url = $qrCode::tickToImageUrl($tick);
```

#### Menu
```php
$buttons = [
        [
            "type" => "click",
            "name" => "今日歌曲",
            "key"  => "V1001_TODAY_MUSIC"
        ],
        [
            "name"       => "菜单",
            "sub_button" => [
                [
                    "type" => "view",
                    "name" => "搜索",
                    "url"  => "http://www.soso.com/"
                ],
                [
                    "type" => "view",
                    "name" => "视频",
                    "url"  => "http://v.qq.com/"
                ],
                [
                    "type" => "click",
                    "name" => "赞一下我们",
                    "key" => "V1001_GOOD"
                ],
            ],
        ],
    ];

    $matchRule = [
        "tag_id" => "2",
        "sex" => "1",
        "country" => "中国",
        "province" => "广东",
        "city" => "广州",
        "client_platform_type" => "2",
        "language" => "zh_CN"
    ];
    
    // create menu
    $wechat->officialAccount()->menu()->create($buttons);
    // create conditional menu
    $menuId = $wechat->officialAccount()->menu()->create($buttons, $matchRule);
    // query menu
    $wechat->officialAccount()->menu()->query();
    // menu conditional menu
    $wechat->officialAccount()->menu()->match('openid OR wechat ID');
    // delete all menu
    $wechat->officialAccount()->menu()->delete();
    // delete conditional menu
    $wechat->officialAccount()->menu()->delete($menuId);

```

#### JSAPI
```php
    // jsApi instance
    $jsApi = $wechat->officialAccount()->jsApi();

    // web authorization redirect link
    $jsAuthRequest = new JsAuthRequest;
    $jsAuthRequest->setRedirectUri('http://m.evalor.cn');
    $jsAuthRequest->setState('test');
    $jsAuthRequest->setType($jsAuthRequest::TYPE_USER_INFO); // 
    $link = $jsApi->auth()->generateURL($jsAuthRequest);
    
    // code to access token
    $code = '' // auth code from url param
    $snsAuthBean  = $jsApi->auth()->codeToToken($code);
    $snsAuthBean->getScope();
    $snsAuthBean->getOpenid();
    $snsAuthBean->getAccessToken();
    $snsAuthBean->getRefreshToken();
    
    // access token to user info
    $userInfo = $jsApi->auth()->tokenToUser($snsAuthBean->getAccessToken());
    $user->getOpenid();
    $user->getHeadimgurl();
    $user->getNickname(); // ... and more
    
    // code to user info
    $user = $jsApi->auth()->codeToUser($code);  // then get user info like above
    
    // refresh access token
    $token = $snsAuthBean->getRefreshToken(); // refresh token need to be stored by yourself
    $snsAuthBean = $jsApi->auth()->refreshToken($token);
    
    // ckeck token (openid and access token is required)
    $snsAuthBean->setOpenid();
    $snsAuthBean->setAccessToken();
    $check = $jsApi->auth()->authCheck($snsAuthBean);
    
    $url = '';  // current request url given by yourself
    // jsApi signature (this is the information wx.config needs)
    $jsApiSignaturePack = $jsApi->sdk()->signature($url);
    $jsApiSignaturePack->getAppId();
    $jsApiSignaturePack->getNonceStr();
    $jsApiSignaturePack->getSignature();
    $jsApiSignaturePack->getTimestamp();
    
```