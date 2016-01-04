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
    public function create($aConfig)
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, $aConfig);
    }

    /**
     * 自定义菜单查询接口。
     * @return array
     */
    public function get()
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=' . $this->sAccessToken;
        return $this->curlGet($sURL);
    }

    /**
     * 创建个性化菜单。
     * @param array $aConfig 配置信息，具体结构参考官方文档。
     * @return array
     */
    public function addConditional($aConfig)
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, $aConfig);
    }

    /**
     * 删除个性化菜单。
     * @param int $iMenuID 菜单ID。
     * @return array
     */
    public function delConditional($iMenuID)
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/menu/delconditional?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, ['menuid' => $iMenuID]);
    }

    /**
     * 获得自定义菜单的配置。
     * @return array
     */
    public function getCurrentSelfmenuInfo()
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token=' . $this->sAccessToken;
        return $this->curlGet($sURL);
    }
}

# end of this file
