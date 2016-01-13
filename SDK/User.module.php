<?php
/**
 * 用户管理。
 */

namespace weixin;

class User extends Base
{
    /**
     * 获得用openid列表。
     * @param string $sNextOpenID 第一个拉取的OPENID，不填默认从头开始拉取
     * @return array
     */
    public function getUserOpenidList($sNextOpenID = '')
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token=' . $this->sAccessToken;

        if ($sNextOpenID !== '') {
            $sURL .= '&next_openid=' . $sNextOpenID;
        }

        return $this->curlGet($sURL);
    }

    /**
     * 批量获得用户信息。
     * @param array $aUserList 用户openid列表。
     * @return array
     */
    public function getUserListInfo($aUserList)
    {
        $aParam['user_list'] = array_map(function($v){
            return ['openid' => $v];
        }, $aUserList);

        $sURL = 'https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=' . $this->sAccessToken;

        return $this->curlPost($sURL, $aParam);
    }

    /**
     * 批量加入某组。
     * @param int $iGroupID
     * @param array $aOpenIDs
     * @return array
     */
    public function joinGroup($iGroupID, $aOpenIDs)
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/groups/members/batchupdate?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, ['openid_list' => $aOpenIDs, 'to_groupid' => $iGroupID]);
    }

    /**
     * 获得用户分组列表。
     * @return array
     */
    public function getUserGroupList()
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/groups/get?access_token=' . $this->sAccessToken;
        return $this->curlGet($sURL);
    }

    /**
     * 创建分组。
     * @param string $sName
     * @return array
     */
    public function createGroup($sName)
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/groups/create?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, ['group' => ['name' => $sName]]);
    }

    /**
     * 删除分组。
     * @param int $iGroupID
     * @return array
     */
    public function delGroup($iGroupID)
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/groups/delete?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, ['group' => ['id' => $iGroupID]]);
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
