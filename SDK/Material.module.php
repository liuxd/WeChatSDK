<?php
/**
 * 自定义菜单管理。
 */

namespace weixin;

class Material extends Base
{
    /**
     * 获得素材列表。
     * @param array $aParams 配置信息，具体结构参考官方文档。
     * @return array
     */
    public function batchGet($aParams)
    {
        $sAccessToken = $this->getGlobalAccessToken();
        $sURL = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=' . $sAccessToken;
        return json_decode($this->curlPost($sURL, $aParams), true);
    }

    /**
     * 获得素材数量。
     * @param array $aParams 配置信息，具体结构参考官方文档。
     * @return array
     */
    public function batchCount()
    {
        $sAccessToken = $this->getGlobalAccessToken();
        $sURL = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=' . $sAccessToken;
        return json_decode($this->curlGet($sURL), true);
    }

    /**
     * 新增永久图文素材。
     * @param array $aInfo
     * @return array
     */
    public function addNews($aInfo)
    {
        $sAccessToken = $this->getGlobalAccessToken();
        $sURL = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=' . $sAccessToken;
        return json_decode($this->curlPost($sURL, $aInfo), true);
    }

    /**
     * 获得永久素材。
     * @param string $sMediaID 素材ID。
     * @return array
     */
    public function getMaterial($sMediaID)
    {
        $sAccessToken = $this->getGlobalAccessToken();
        $sURL = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=' . $sAccessToken;
        $aReturn = $this->curlPost($sURL, ['media_id' => $sMediaID]);

        if (is_string($aReturn)) {
            return json_decode($aReturn, true);
        }

        return false;
    }
}

# end of this file
