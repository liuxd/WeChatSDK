<?php
/**
 * 自定义菜单管理。
 */

namespace weixin;

class Menu extends Base
{
    /**
     * 创建自定义菜单配置。
     * @param array $aConfig 配置信息，具体结构参考官方文档。
     * @return array
     */
    public function createConfig($aConfig)
    {
        $sAccessToken = $this->getGlobalAccessToken();
        $sURL = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $sAccessToken;
        return $this->curlPost($sURL, $aConfig);
    }

    /**
     * 获得自定义菜单的配置。
     * @return array
     */
    public function getConfig()
    {
        $sAccessToken = $this->getGlobalAccessToken();
        $sURL = 'https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token=' . $sAccessToken;
        return json_decode($this->curlGet($sURL), true);
    }
}

# end of this file
