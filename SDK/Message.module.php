<?php
/**
 * 自定义菜单管理。
 */

namespace weixin;

class Message extends Base
{
    /**
     * 发送模板消息。
     * @param string $sMessageTemplateID 模板ID。
     * @param string $sToUser 目标用户。
     * @param array $aData 消息内容。
     * @return array
     */
    public function pushMessage($sMessageTemplateID, $sToUser, $aData)
    {
        $aData['touser'] = $sToUser;
        $aData['template_id'] = $sMessageTemplateID;

        $sURL = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, $aData);
    }
}

# end of this file
