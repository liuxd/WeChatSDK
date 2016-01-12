<?php
/**
 * 消息推送。
 */

namespace weixin;

class Message extends Base
{
    /**
     * 发送模板消息。
     * @param string $sMessageTemplateID 模板ID。
     * @param string $sToUser 目标用户。
     * @param array $aData 消息内容。
     * @param string $sURL 点击的URL。
     * @return array
     */
    public function pushMessage($sMessageTemplateID, $sToUser, $aData, $sURL = '')
    {
        $aBody['touser'] = $sToUser;
        $aBody['template_id'] = $sMessageTemplateID;
        $aBody['data'] = $aData;

        if ($sURL !== '') {
            $aBody['url'] = $sURL;
        }

        $sURL = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, $aBody);
    }
}

# end of this file
