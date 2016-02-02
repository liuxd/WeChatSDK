<?php
/**
 * 素材管理。
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
        $sURL = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, $aParams);
    }

    /**
     * 获得素材数量。
     * @param array $aParams 配置信息，具体结构参考官方文档。
     * @return array
     */
    public function batchCount()
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=' . $this->sAccessToken;
        return $this->curlGet($sURL);
    }

    /**
     * 新增永久图文素材。
     * @param array $aInfo
     * @return array
     */
    public function addNews($aInfo)
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, $aInfo);
    }

    /**
     * 获得永久素材。
     * @param string $sMediaID 素材ID。
     * @return array
     */
    public function getMaterial($sMediaID)
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, ['media_id' => $sMediaID]);
    }
}

# end of this file
