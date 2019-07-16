# EasySwoole WeChat
EasySwoole WeChat is an Whole-Coroutine WeChat SDK Which is base on swoole 4.x ,We Design this SDK just because we need faster than faster !
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
    $user = $jsApi->auth()->tokenToUser($snsAuthBean);
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
    $jsApiSignaturePack = $jsApi->jsApi()->sdk()->signature($url);
    $jsApiSignaturePack->getAppId();
    $jsApiSignaturePack->getNonceStr();
    $jsApiSignaturePack->getSignature();
    $jsApiSignaturePack->getTimestamp();
    
```

#### Media
```php
    use Swoole\Coroutine;
    use EasySwoole\WeChat\Bean\OfficialAccount\MediaRequest;
    use EasySwoole\WeChat\Bean\OfficialAccount\MediaResponse;
    
    // upload
    $path = 'image.jpg';
    $type = MediaRequest::TYPE_IMAGE;
    
    // the path type
    $mediaBean = new MediaRequest(); // or new MediaRequest(['path' => $path, 'type' => $type);
    $mediaBean->setPath($path);
    $mediaBean->setType($type);
    $response = $wechat->officialAccount()->media()->upload($mediaBean);
    
    // the stream
    $stream = Coroutine::readFile($path);
    $mediaBean = new MediaRequest();
    $mediaBean->setType($type);
    $mediaBean->setData($stream);
    $response = $wechat->officialAccount()->media()->upload($mediaBean);
    
    // get 
    $response = $wechat->officialAccount()->media()->get($mediaId);
    if($response instanceof MediaResponse) {
        $response->save($directory); 
        // or 
        $response->saveAs($directory, $filename)
    }
    
    // if get media type is video
    $response = [
        'video_url': $downUrl
    ]
```

#### Material
```php
    // upload
    use EasySwoole\WeChat\Bean\OfficialAccount\MediaRequest;
    use EasySwoole\WeChat\Bean\OfficialAccount\MediaArticle;
    
    $mediaBean = new MediaRequest();
    $mediaBean->setPath('thumb.jpg');
    $mediaBean->setType(MediaRequest::TYPE_THUMB);
    
    // if media type is video must setTitle and setIntroduction
    // $mediaBean->setTitle('title');
    // $mediaBean->setIntroduction('introduction');
        
    $mediaUploadResponse = $wechat->officialAccount()->material()->upload($mediaBean)['media_id'];
    $thumbMediaId = $mediaUploadResponse['media_id'];
        
    // upload article
    $article = [
        'title' => 'EasySwoole/Wechat！',
        'thumb_media_id' => $thumbMediaId,
        'author' => 'EasySwoole/Wechat',
        'show_cover' => 1,
        'digest' => 'digest',
        'content' => 'content',
        'source_url' => 'https://www.easyswoole.com',
    ];

    $mediaArticle_0 = new MediaArticle($article);
    $mediaArticle_1 = new MediaArticle($article);
    // uploadArticle parameter is `Variable-length argument lists` but parameter must be MediaArticle object
    $uploadArticleResponse = $wechat->officialAccount()->material()->uploadArticle($mediaArticle_0, $mediaArticle_1);

    // get media
    $materialGetResponse = $wechat->officialAccount()->material()->get($uploadArticleResponse['media_id']);

    // upload article image
    $mediaBean = new MediaRequest();
    $mediaBean->setPath('image.jpg');
    $mediaBean->setType(MediaRequest::TYPE_IMAGE);
    // uploadArticleImage will not return media_id
    $imageUrl = $wechat->officialAccount()->material()->uploadArticleImage($mediaBean)['url'];

    // update article
    $newMediaArticle_0 = new MediaArticle($materialGetResponse['news_item'][0]);
    $newMediaArticle_0->setContent("<img src='{$imageUrl}' alt='image alt'>");
    $updateArticleResponse = $wechat->officialAccount()->material()->updateArticle($uploadArticleResponse['media_id'], $newMediaArticle_0, 0);

    // delete media
    $materialDeleteResponse = $wechat->officialAccount()->material()->delete($uploadArticleResponse['media_id']);
```


## WeChat MiniProgram (New)

Current support auth、qrcode with WeChat MiniProgram ( Automatic access token management )

### create wxa instance

First you need to initialize an instance

```php
$wxa = new \EasySwoole\WeChat\MiniProgram\MiniProgram;
$wxa->getConfig()->setAppId('your appid')->setAppSecret('your appsecret');
```

### wxa session

You can see [open-ability-login](https://developers.weixin.qq.com/miniprogram/en/dev/framework/open-ability/login.html) for details. Suppose you've got the code you need to log in: 

```php
$code = '';
$session = $wxa->auth()->session($code);
```

You will get an array containing the fields described in the document, see [code2Session](https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/login/auth.code2Session.html)

### create qrcode

From the [documentation](https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/qr-code/wxacode.createQRCode.html), we can see that there are three ways to create qccodes.

```
$response1 = $wxa->qrCode()->getWxaCode('/pages/index/index', 450);
$response2 = $wxa->qrCode()->getWxaCodeUnLimit('/pages/index/index', 'scene');
$response3 = $wxa->qrCode()->createWxaQrCode('/pages/index/index', 450);
```

This seems too simple, and the method can support more parameters, as follows:

```
 function getWxaCode($path, $width = 430, $autoColor = false, $lineColor = null, $isHyaline = false){}
 function getWxaCodeUnLimit($path, $scene, $width = 430, $autoColor = false, $lineColor = null, $isHyaline = false)
 function createWxaQrCode($path, $width = 430)
```