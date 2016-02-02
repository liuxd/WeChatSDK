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

    /**
     * 按用户组进行群发消息。
     * @param int $iGroupID 用户组ID。
     * @param string $sMsgType 消息类型。可能值：图文消息为mpnews，文本消息为text，语音为voice，音乐为music，图片为image，视频为video，卡券为wxcard。
     * @param array $aData 消息内容。参考官方文档：http://mp.weixin.qq.com/wiki/15/40b6865b893947b764e2de8e4a1fb55f.html#.E6.A0.B9.E6.8D.AE.E5.88.86.E7.BB.84.E8.BF.9B.E8.A1.8C.E7.BE.A4.E5.8F.91.E3.80.90.E8.AE.A2.E9.98.85.E5.8F.B7.E4.B8.8E.E6.9C.8D.E5.8A.A1.E5.8F.B7.E8.AE.A4.E8.AF.81.E5.90.8E.E5.9D.87.E5.8F.AF.E7.94.A8.E3.80.91
     * @param bool $bIsToAll 是否推送给所有人。
     * @return array
     */
    public function multiPushByGroup($iGroupID, $sMsgType, $aData, $bIsToAll = false)
    {
        if ((int)$iGroupID === 0) {
            return ['errcode' => -2, 'errmsg' => 'group_id should not be 0!!!!!'];
        }

        $aBody = [
            'filter' => [
                'is_to_all' => $bIsToAll,
                'group_id' => $iGroupID
            ],
            'msgtype' => $sMsgType,
            $sMsgType => $aData
        ];

        $sURL = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, $aBody);
    }

    /**
     * 按用户组进行群发消息。
     * @param array $aOpenIDList 用户openid列表。
     * @param string $sMsgType 消息类型。可能值：图文消息为mpnews，文本消息为text，语音为voice，音乐为music，图片为image，视频为video，卡券为wxcard。
     * @param array $aData 消息内容。参考官方文档：http://mp.weixin.qq.com/wiki/15/40b6865b893947b764e2de8e4a1fb55f.html#.E6.A0.B9.E6.8D.AE.E5.88.86.E7.BB.84.E8.BF.9B.E8.A1.8C.E7.BE.A4.E5.8F.91.E3.80.90.E8.AE.A2.E9.98.85.E5.8F.B7.E4.B8.8E.E6.9C.8D.E5.8A.A1.E5.8F.B7.E8.AE.A4.E8.AF.81.E5.90.8E.E5.9D.87.E5.8F.AF.E7.94.A8.E3.80.91
     * @return array
     */
    public function multiPushByOpenID($aOpenIDList, $sMsgType, $aData)
    {
        $aBody = [
            'touser' => $aOpenIDList,
            'msgtype' => $sMsgType,
            $sMsgType => $aData
        ];

        $sURL = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, $aBody);
    }

    /**
     * 查看发送消息的状态。
     * @param int $iMsgID
     * @return array
     */
    public function getMessageStatus($iMsgID)
    {
        $sURL = 'https://api.weixin.qq.com/cgi-bin/message/mass/get?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, ['msg_id' => $iMsgID]);
    }
}

# end of this file
