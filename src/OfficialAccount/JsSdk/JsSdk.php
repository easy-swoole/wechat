<?php


namespace EasySwoole\WeChat\OfficialAccount\JsSdk;


use EasySwoole\WeChat\Kernel\Contracts\ClientInterface;
use EasySwoole\WeChat\Kernel\Contracts\JsSdkTicketInterface;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Kernel\Utility\Random;
use Psr\Http\Message\ResponseInterface;

class JsSdk
{

    const SCOPE_SNSAPI_BASE = 'snsapi_base';
    const SCOPE_SNSAPI_USER_INFO = 'snsapi_userinfo';

    /** @var ServiceContainer  */
    protected $app;

    protected $ticket;

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
        $this->ticket = new Ticket($app);
    }

    public function ticket():JsSdkTicketInterface
    {
        return $this->ticket;
    }

    function signature(string $url)
    {
        //组装签名参数包
        $pack = [
            'noncestr' => Random::character(16),
            'jsapi_ticket' => $this->ticket()->getToken(),
            'timestamp' => time(),
            'url' => $url
        ];
        // 按键名升序
        ksort($pack);
        // 拼接待签名串
        $signatureStr = '';
        foreach ($pack as $name => $value) {
            $signatureStr .= "{$name}={$value}&";
        }
        // 去除最后多拼接的&
        $signatureStr = substr($signatureStr, 0, -1);
        $signature = sha1($signatureStr);
        return [
            'appId' => $this->app[ServiceProviders::Config]->get('appId'),
            'timestamp' => $pack['timestamp'],
            'nonceStr' => $pack['noncestr'],
            'signature' => $signature,
        ];
    }


    function authUrl(string $callback,array $data = []):string
    {
        if(isset($data['scope'])){
            $scope = $data['scope'];
        }else{
            $scope = self::SCOPE_SNSAPI_BASE;
        }
        if(isset($data['state'])){
            $state = $data['state'];
        }else{
            $state = '';
        }
        $appId = $this->app[ServiceProviders::Config]->get('appId');
        $redirect_uri = urlencode($callback);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appId}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
    }

    function authCode2Token(string $authCode):?SnsAuthBean
    {

        $appid = $this->app[ServiceProviders::Config]->get('appId');
        $secret = $this->app[ServiceProviders::Config]->get('appSecret');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$authCode}&grant_type=authorization_code";
        $response = $this->getClient()->setMethod("GET")->send($url);
        if($this->checkResponse($response, $jsonData)){
            return new SnsAuthBean($jsonData);
        }
        return null;
    }

//    function token2Info(string $token)
//    {
//        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN";
//        $response = NetWork::getForJson(ApiUrl::generateURL(ApiUrl::JSAPI_SNS_USERINFO, [
//            'ACCESS_TOKEN' => $authBean->getAccessToken(),
//            'OPENID' => $authBean->getOpenid(),
//        ]));
//        $ex = OfficialAccountError::hasException($response);
//        if ($ex) {
//            throw $ex;
//        } else {
//            return new User($response);
//        }
//    }

    protected function getClient():ClientInterface
    {
        return $this->app[ServiceProviders::HttpClientManager]->getClient();
    }

    protected function checkResponse(ResponseInterface $response, &$parseData)
    {
        if (200 !== $response->getStatusCode()) {
            throw new HttpException(
                $response->getBody()->__toString(),
                $response
            );
        }

        $data = json_decode($response->getBody()->__toString(),true);
        $parseData = $data;

        if (isset($data['errcode']) && (int)$data['errcode'] !== 0) {
            throw new HttpException(
                "refresh access_token fail, message: ({$data['errcode']}) {$data['errmsg']}",
                $response,
                $data['errcode']
            );
        }

        return true;
    }
}