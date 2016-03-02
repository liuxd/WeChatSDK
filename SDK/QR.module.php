<?php
/**
 * 二维码。
 */

namespace weixin;

class QR extends Base
{
    /**
     * 获得临时ticket。
     * @param int $iExpires 过期时间。
     * @param int $iSceneID 场景ID。
     * @return array
     */
    public function getTempTicket($iExpires, $iSceneID)
    {
        $aData = [
            'expire_seconds' => (int)$iExpires,
            'action_name' => 'QR_SCENE',
            'action_info' => [
                'scene' => [
                    'scene_id' => (int)$iSceneID
                ]
            ]
        ];

        $sURL = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, $aData);
    }

    /**
     * 获得永久ticket。
     * @param string $sSceneString 场景值。
     * @return array
     */
    public function getTicket($sSceneString)
    {
        $aData = [
            'action_name' => 'QR_LIMIT_STR_SCENE',
            'action_info' => [
                'scene' => [
                    'scene_str' => $sSceneString
                ]
            ]
        ];

        $sURL = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $this->sAccessToken;
        return $this->curlPost($sURL, $aData);
    }

    /**
     * 获得二维码图片的链接。
     * @param string $sTicket
     * @return string
     */
    public function getQR($sTicket)
    {
        return 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($sTicket);
    }
}

# end of this file
