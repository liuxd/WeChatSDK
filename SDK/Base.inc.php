<?php

namespace weixin;

class Base
{
    protected $sAppID = '';
    protected $sSecret = '';

    private $sAccessTokenRedisKey = 'weixin_access_token';
    private $oRedis = null;

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

    private function getRedis()
    {
        if (!is_null($this->oRedis)) {
            return $this->oRedis;
        }

        $sHost = '127.0.0.1';
        $iPort = 6379;

        $sConfigFile = __DIR__ . DIRECTORY_SEPARATOR . 'config.ini';

        if (file_exists($sConfigFile)) {
            $aConfig = parse_ini_file($sConfigFile, true);

            if (isset($aConfig['redis'])) {
                $sHost = $aConfig['redis']['host'];
                $iPort = $aConfig['redis']['port'];
            }
        }

        $this->oRedis = new \Redis;
        $this->oRedis->connect($sHost, $iPort);

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
}

# end of this file
