<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 9:32 PM
 */

namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\AbstractInterface\AccessTokenInterface;

class MiniProgram
{
    private $accessToken;
    private $attest;
    private $config;
    private $auth;
    private $checkFile;
    private $encryptor;
    private $logisticsProgram;
    private $logisticsService;
    private $plugin;
    private $program;
    private $qrCode;
    private $subscribeMsg;
    private $urlScheme;
    private $templateMsg;

    public function __construct(MiniProgramConfig $config = null, AccessTokenInterface $accessToken = null)
    {
        if (is_null($config)) {
            $config = new MiniProgramConfig;
        }

        if (!is_null($accessToken)) {
            $this->accessToken = $accessToken;
        }

        $this->config = $config;
    }

    /**
     * getConfig
     *
     * @return MiniProgramConfig
     */
    public function getConfig(): MiniProgramConfig
    {
        return $this->config;
    }

    /**
     * auth
     *
     * @return Auth
     */
    public function auth(): Auth
    {
        if (!isset($this->auth)) {
            $this->auth = new Auth($this);
        }

        return $this->auth;
    }

    /**
     * encryptor
     *
     * @return Encryptor
     */
    public function encryptor(): Encryptor
    {
        if (!isset($this->encryptor)) {
            $this->encryptor = new Encryptor($this);
        }

        return $this->encryptor;
    }

    /**
     * accessToken
     *
     * @return AccessTokenInterface
     */
    public function accessToken(): AccessTokenInterface
    {
        if (!isset($this->accessToken)) {
            $this->accessToken = new AccessToken($this);
        }

        return $this->accessToken;
    }

    public function setAccessTokenManager(AccessTokenInterface $accessToken): MiniProgram
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * qrCode
     *
     * @return QrCode
     */
    public function qrCode(): QrCode
    {
        if (!isset($this->qrCode)) {
            $this->qrCode = new QrCode($this);
        }

        return $this->qrCode;
    }

    /**
     * templateMsg
     *
     * @return TemplateMsg
     */
    public function templateMsg(): TemplateMsg
    {
        if (!isset($this->templateMsg)) {
            $this->templateMsg = new TemplateMsg($this);
        }

        return $this->templateMsg;
    }

    /**
     * @return SubscribeMsg
     */
    public function subscribeMsg(): SubscribeMsg
    {
        if (!isset($this->subscribeMsg)) {
            $this->subscribeMsg = new SubscribeMsg($this);
        }

        return $this->subscribeMsg;
    }

    /**
     * @return UrlScheme
     */
    public function urlScheme(): UrlScheme
    {
        if (!isset($this->urlScheme)) {
            $this->urlScheme = new UrlScheme($this);
        }

        return $this->urlScheme;
    }

    /**
     * @return CheckFile
     */
    public function checkFile()
    {
        if (!isset($this->checkFile)) {
            $this->checkFile = new CheckFile($this);
        }

        return $this->checkFile;
    }

    /**
     * @return Attest
     */
    public function attest()
    {
        if (!isset($this->attest)) {
            $this->attest = new Attest($this);
        }

        return $this->attest;
    }

    /**
     * @return LogisticsProgram
     */
    public function logisticsProgram()
    {
        if (!isset($this->logisticsProgram)) {
            $this->logisticsProgram = new LogisticsProgram($this);
        }
        return $this->logisticsProgram;
    }

    /**
     * @return LogisticsService
     */
    public function logisticsService()
    {
        if (!isset($this->logisticsService)) {
            $this->logisticsService = new LogisticsService($this);
        }
        return $this->logisticsService;
    }

    /**
     * @return Plugin
     */
    public function plugin()
    {
        if (!isset($this->plugin)) {
            $this->plugin = new Plugin($this);
        }
        return $this->plugin;
    }

    /**
     * @return Program
     */
    public function program()
    {
        if (!isset($this->program)) {
            $this->program = new Program($this);
        }
        return $this->program;
    }
}
