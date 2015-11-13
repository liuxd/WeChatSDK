<?php

namespace weixin;

class Base
{
    protected $sAppID = '';
    protected $sSecret = '';

    private $sAccessTokenRedisKey = 'weixin_access_token';
    private $oRedis = null;
    private $bSetRedis = false;

    public function __construct($sAppID, $sSecret)
    {
        $this->sAppID = $sAppID;
        $this->sSecret = $sSecret;
    }

    /**
     * 获得全局接口凭据。
     * @return string
     */
    public function getGlobalAccessToken()
    {
        $oRedis = $this->getRedis();
        $sAccessToken = $oRedis->get($this->sAccessTokenRedisKey);

        if (!empty($sAccessToken)) {
            return $sAccessToken;
        }

        $sURL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->sAppID}&secret={$this->sSecret}";
        $aReturn = json_decode($this->curlGet($sURL), true);

        if (isset($aReturn['access_token'])) {
            $oRedis->set($this->sAccessTokenRedisKey, $aReturn['access_token']);
            $oRedis->setTimeout($this->sAccessTokenRedisKey, $aReturn['expires_in']);
        }

        return $aReturn['access_token'];
    }

    /**
     * 从外部注入Redis对象。
     * @param Redis $oRedis
     * @return bool
     */
    public function setRedis($oRedis)
    {
        $bReturn = false;

        if ($oRedis instanceof \Redis) {
            $this->oRedis = $oRedis;
            $this->bSetRedis = true;
            $bReturn = true;
        }

        return $bReturn;
    }

    /**
     * 获得Redis对象。
     * @return Redis
     */
    private function getRedis()
    {
        if (!$this->bSetRedis && is_null($this->oRedis)) {
            $this->oRedis = new \Redis;
            $this->oRedis->connect('127.0.0.1', 6379);
        }

        return $this->oRedis;
    }

    /**
     * 获得页面的返回值。
     * @param string $sURL
     * @return string
     */
    protected function curlGet($sURL)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $sURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  

        $aResult = curl_exec($ch);
        curl_close($ch);

        return $aResult;
    }

    protected function curlPost($sURL, $aData)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $sURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($aData, JSON_UNESCAPED_UNICODE));

        $aResult = curl_exec($ch);
        curl_close($ch);

        return $aResult;
    }
}

# end of this file
