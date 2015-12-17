<?php
/**
 * 用户管理。
 */

namespace weixin;

class User extends Base
{
    /**
     * 获得用户分组列表。
     * @return array
     */
    public function getUserGroupList()
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $this->sAccessToken;
        return $this->curlGet($sURL);
    }

    /**
     * 获得授权用户的信息。
     * @param string $code 回调页面获得的临时code。
     * @return array
     */
    public function getUserInfo($code)
    {
        $aInfo = $this->getAccessToken($code);
        $aUserInfo = $this->getUserWeixinInfo($aInfo['access_token'], $aInfo['openid']);

        return $aUserInfo;
    }

    /**
     * 获得临时access_token、OpenID等信息。
     * @param string $code
     * @return array
     */
    private function getAccessToken($code)
    {
        $sURL = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->sAppID}&secret={$this->sSecret}&code={$code}&grant_type=authorization_code";
        return $this->curlGet($sURL);
    }

    /**
     * 使用access_token获得完整的用户信息。
     * @param string $access_token
     * @param string $open_id
     * @return array
     */
    private function getUserWeixinInfo($access_token, $openid)
    {
        $sURL = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        return $this->curlGet($sURL);
    }

}

# end of this file
