<?php
/**
 * Start with : https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx1061e4e55dd6de25&redirect_uri=http%3a%2f%2fliuxd.sinaapp.com%2f&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect
 */

class Weixin
{
	public function main()
	{
		$mmc = memcache_connect();

		if (isset($_GET['show'])) {
			see(memcache_get($mmc, 'code'));
			see(json_decode(memcache_get($mmc, 'info'), true));
			see(json_decode(memcache_get($mmc, 'user'), true));
		} else {
			$code = $this->getCode();
			$user = $this->getUserInfo($code);
			see($user);
		}
	}

	public function getUserInfo($code)
	{
		$info = $this->getAccessToken($code);
		$user = $this->getUserWeixinInfo($info['access_token'], $info['openid']);

		return $user;
	}

	/**
	 * 获得临时code
	 * @return string
	 */
	private function getCode()
	{
		return $_GET['code'];
	}

	/**
	 * 获得临时access_token和OpenID等信息。
	 * @param string $code
	 * @return array
	 */
	private function getAccessToken($code)
	{
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx1061e4e55dd6de25&secret=9dbfb0f945333b1c141cbc215aa734c3&code={$code}&grant_type=authorization_code";
		return json_decode($this->curlPost($url), true);
	}

	/**
	 * 获得用户信息
	 * @param string $access_token
	 * @return array
	 */
	private function getUserWeixinInfo($access_token, $open_id)
	{
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
		return json_decode($this->curlPost($url), true);
	}

    private function curlPost($url)
    {
        $ch = curl_init();

        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt ($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  

        $file_contents = curl_exec($ch);
        curl_close($ch);

        return $file_contents;
    }
}

require __DIR__ . '/inc.php';
(new Weixin)->main();

# end of this file
