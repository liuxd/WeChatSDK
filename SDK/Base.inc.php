<?php

namespace weixin;

class Base
{
	protected $sAppID = '';
	protected $sSecret = '';

	public function __construct($sAppID, $sSecret)
	{
		$this->sAppID = $sAppID;
		$this->sSecret = $sSecret;
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
