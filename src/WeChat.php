<?php

namespace RSHDSDK;

use Exception;

class WeChat extends Project
{
    /**
     * @param string $appid 小程序appid
     * @param string $out_trade_no 商户订单号
     * @param string $description 订单中文描述
     * @param string $notify_url 回调地址
     * @param integer $amount_total 订单金额
     * @param string $payer_openid 支付用户的openid
     * @return array
     * @throws Exception
     */
    public function miniPay($appid, $out_trade_no, $description, $notify_url, $amount_total, $payer_openid)
    {
        if (empty($appid) || empty($out_trade_no) || empty($description) || empty($amount_total) || empty($payer_openid)) {
            throw new Exception('参数不能为空');
        }

        return $this->client->apiPostRequest('/we_chat/miniPay', [
            'appid'        => $appid,
            'out_trade_no' => $out_trade_no,
            'description'  => $description,
            'notify_url'   => $notify_url,
            'amount_total' => $amount_total,
            'payer_openid' => $payer_openid,
        ]);
    }

    /**
     * 小程序，通过微信订单号查询订单
     * @param string $number
     * @return array
     * @throws Exception
     */
    public function miniGetOrderByWeChat($number)
    {
        if (empty($number)) {
            throw new Exception('参数不能为空');
        }

        return $this->client->apiPostRequest('/we_chat/miniGetOrderByWeChat', [
            'number' => $number,
        ]);
    }

    /**
     * 小程序，通过商户订单号查询订单
     * @param string $number
     * @return array
     * @throws Exception
     */
    public function miniGetOrderByOut($number)
    {
        if (empty($number)) {
            throw new Exception('参数不能为空');
        }

        return $this->client->apiPostRequest('/we_chat/miniGetOrderByOut', [
            'number' => $number,
        ]);
    }

    /**
     * 解密支付、退款后的回调数据
     * @param string $associated_data
     * @param string $nonce
     * @param string $ciphertext
     * @return array
     * @throws Exception
     * @since 2.2
     */
    public function decodeCallBack($associated_data, $nonce, $ciphertext)
    {
        if (empty($nonce) || empty($ciphertext)) {
            throw new Exception('缺少必要的参数');
        }

        $body = [
            'nonce'      => $nonce,
            'ciphertext' => $ciphertext,
        ];

        if (empty($associated_data)) {
            $body['associated_data'] = '';
        } else {
            $body['associated_data'] = $associated_data;
        }

        return $this->client->apiPostRequest('/we_chat/decodeCallBack', $body);
    }

    /**
     * 退款，通过微信订单号
     * @param string $number 微信订单号（必填）
     * @param string $refund_number 商户退款单号，商家自己生成（必填）
     * @param integer $amount_refund 退款金额，整数，单位为分（必填）
     * @param integer $amount_total 订单原始金额，整数，单位为分（必填）
     * @param string $notify_url 回调通知
     * @return array
     * @throws Exception
     * @since 2.3
     */
    public function miniOrderRefundsByWeChat($number, $refund_number, $amount_refund, $amount_total, $notify_url)
    {
        if (empty($number) || empty($refund_number) || empty($amount_refund) || empty($amount_total)) {
            throw new Exception('缺少必要的参数');
        }

        $body = [
            'number'        => $number,
            'refund_number' => $refund_number,
            'amount_refund' => $amount_refund,
            'amount_total'  => $amount_total,
        ];

        if (!empty($notify_url)) {
            $body['notify_url'] = $notify_url;
        }

        return $this->client->apiPostRequest('/we_chat/miniOrderRefundsByWeChat', $body);
    }

    /**
     * 退款，通过商户订单号
     * @param string $number 商户订单号（必填）
     * @param string $refund_number 商户退款单号，商家自己生成（必填）
     * @param integer $amount_refund 退款金额，整数，单位为分（必填）
     * @param integer $amount_total 订单原始金额，整数，单位为分（必填）
     * @param string $notify_url 回调通知
     * @return array
     * @throws Exception
     * @since 2.3
     */
    public function miniOrderRefundsByOut($number, $refund_number, $amount_refund, $amount_total, $notify_url)
    {
        if (empty($number) || empty($refund_number) || empty($amount_refund) || empty($amount_total)) {
            throw new Exception('缺少必要的参数');
        }

        $body = [
            'number'        => $number,
            'refund_number' => $refund_number,
            'amount_refund' => $amount_refund,
            'amount_total'  => $amount_total,
        ];

        if (!empty($notify_url)) {
            $body['notify_url'] = $notify_url;
        }

        return $this->client->apiPostRequest('/we_chat/miniOrderRefundsByOut', $body);
    }

    /**
     * 生成小程序URL Link
     * @param string $path
     * @param string $query
     * @param numeric $expire_type
     * @param numeric $expire_time
     * @param numeric $expire_interval
     * @return array
     * @throws Exception
     * @since 2.10
     */
    public function miniGenerateUrlLink($path = null, $query = null, $expire_type = null, $expire_time = null, $expire_interval = null)
    {
        $message = [];

        if (!empty($path)) {
            $message['path'] = $path;
        }

        if (!empty($query)) {
            $message['query'] = $query;
        }

        if (!empty($expire_type)) {
            $message['expire_type'] = $expire_type;
        }

        if (!empty($expire_time)) {
            $message['expire_time'] = $expire_time;
        }

        if (!empty($expire_interval)) {
            $message['expire_interval'] = $expire_interval;
        }

        return $this->client->apiPostRequest('/we_chat/miniGenerateUrlLink', ['message' => json_encode($message)]);
    }

    /**
     * 获取不限制的小程序二维码
     * @param string $scene 场景名称
     * @param string $page
     * @param integer $width
     * @param bool $check_path
     * @param string $env_version
     * @param bool $auto_color
     * @param array $line_color
     * @param bool $is_hyaline
     * @return array
     * @throws Exception
     * @since 2.10
     */
    public function miniUnlimitedQRCode($scene, $page = null, $width = null, $check_path = null, $env_version = null,
                                        $auto_color = null, $line_color = [], $is_hyaline = null)
    {
        if (empty($scene)) {
            throw new Exception('scene 参数不能为空');
        }

        $message = [];

        $message['scene'] = $scene;

        if (!empty($page)) {
            $message['page'] = $page;
        }

        if (!empty($check_path)) {
            $message['check_path'] = $check_path;
        }

        if (!empty($env_version)) {
            $message['env_version'] = $env_version;
        }

        if (!empty($width)) {
            $message['width'] = $width;
        }

        if (!empty($auto_color)) {
            $message['auto_color'] = $auto_color;
        }

        if (!empty($line_color)) {
            $message['line_color'] = $line_color;
        }

        if (!empty($is_hyaline)) {
            $message['is_hyaline'] = $is_hyaline;
        }

        return $this->client->apiPostRequest('/we_chat/miniUnlimitedQRCode', ['message' => json_encode($message)]);
    }

    /**
     * 公众号-发送模版消息
     * @param string $to_user_openid
     * @param string $template_id
     * @param string $url
     * @param array $miniprogram
     * @param array $data
     * @param string $client_msg_id
     * @return array
     * @throws Exception
     * @since 2.10
     */
    public function officialTemplateMessageSend($to_user_openid, $template_id, $url = null, $miniprogram = [],
                                                $data = [], $client_msg_id = null)
    {
        if (empty($to_user_openid)) {
            throw new Exception('to_user_openid 不能为空');
        }

        if (empty($template_id)) {
            throw new Exception('template_id 不能为空');
        }

        $message = [];

        if (!empty($url)) {
            $message['url'] = $url;
        }

        if (!empty($miniprogram)) {
            $message['miniprogram'] = $miniprogram;
        }

        if (!empty($data)) {
            $message['data'] = $data;
        }

        if (!empty($client_msg_id)) {
            $message['client_msg_id'] = $client_msg_id;
        }

        return $this->client->apiPostRequest('/we_chat/officialTemplateMessageSend', ['message' => json_encode($message)]);
    }

    /**
     * 公众号-创建菜单
     * @param array $button 菜单数组
     * @return array
     * @throws Exception
     * @since 2.10
     */
    public function officialCreateMenu($button)
    {
        if (empty($button)) {
            throw new Exception('button 不能为空');
        }

        return $this->client->apiPostRequest('/we_chat/officialCreateMenu', ['button' => json_encode($button)]);
    }

    /**
     * 公众号-删除菜单
     * @return array
     * @throws Exception
     * @since 2.10
     */
    public function officialDeleteMenu()
    {
        return $this->client->apiPostRequest('/we_chat/officialDeleteMenu', []);
    }

    /**
     * @param array $message
     * @return array
     * @throws Exception
     * @since 2.10
     */
    public function officialCustomSend($message)
    {
        if (empty($message)) {
            throw new Exception('message 不能为空');
        }

        return $this->client->apiPostRequest('/we_chat/officialCustomSend', ['message' => json_encode($message)]);
    }

    /**
     * 公众号-发送文本消息
     * @param string $to_user_openid
     * @param string $content
     * @return array
     * @throws Exception
     * @since 2.10
     */
    public function officialCustomSendText($to_user_openid, $content)
    {
        if (empty($to_user_openid)) {
            throw new Exception('to_user_openid 不能为空');
        }

        if (empty($content)) {
            throw new Exception('content 不能为空');
        }

        return $this->officialCustomSend([
            'touser'  => $to_user_openid,
            'msgtype' => 'text',
            'text'    => [
                'content' => $content
            ],
        ]);
    }

    /**
     * 公众号-发送图片消息
     * @param string $to_user_openid
     * @param string $media_id
     * @return array
     * @throws Exception
     * @since 2.10
     */
    public function officialCustomSendImage($to_user_openid, $media_id)
    {
        if (empty($to_user_openid)) {
            throw new Exception('to_user_openid 不能为空');
        }

        if (empty($media_id)) {
            throw new Exception('media_id 不能为空');
        }

        return $this->officialCustomSend([
            'touser'  => $to_user_openid,
            'msgtype' => 'image',
            'image'   => [
                'media_id' => $media_id
            ],
        ]);
    }

    /**
     * 公众号-发送语音消息
     * @param string $to_user_openid
     * @param string $media_id
     * @return array
     * @throws Exception
     * @since 2.10
     */
    public function officialCustomSendVoice($to_user_openid, $media_id)
    {
        if (empty($to_user_openid)) {
            throw new Exception('to_user_openid 不能为空');
        }

        if (empty($media_id)) {
            throw new Exception('media_id 不能为空');
        }

        return $this->officialCustomSend([
            'touser'  => $to_user_openid,
            'msgtype' => 'voice',
            'voice'   => [
                'media_id' => $media_id
            ],
        ]);
    }

    /**
     * 公众号-发送图文消息（点击跳转到外链） 图文消息条数限制在1条以内，注意，如果图文数超过1，则将会返回错误码45008。
     * @param string $to_user_openid
     * @param string $title
     * @param string $description
     * @param string $url
     * @param string $picurl
     * @return array
     * @throws Exception
     * @since 2.10
     */
    public function officialCustomSendNews($to_user_openid, $title, $description, $url, $picurl)
    {
        if (empty($to_user_openid)) {
            throw new Exception('to_user_openid 不能为空');
        }

        if (empty($title)) {
            throw new Exception('title 不能为空');
        }

        if (empty($description)) {
            throw new Exception('description 不能为空');
        }

        if (empty($url)) {
            throw new Exception('url 不能为空');
        }

        if (empty($picurl)) {
            throw new Exception('picurl 不能为空');
        }

        return $this->officialCustomSend([
            'touser'  => $to_user_openid,
            'msgtype' => 'news',
            'news'    => [
                'title'       => $title,
                'description' => $description,
                'url'         => $url,
                'picurl'      => $picurl,
            ],
        ]);
    }

    /**
     * 公众号-发送图文消息（点击跳转到图文消息页面） 图文消息条数限制在1条以内，注意，如果图文数超过1，则将会返回错误码45008。
     * @param string $to_user_openid
     * @param string $media_id
     * @return array
     * @throws Exception
     * @since 2.10
     */
    public function officialCustomSendMPNews($to_user_openid, $media_id)
    {
        if (empty($to_user_openid)) {
            throw new Exception('to_user_openid 不能为空');
        }

        if (empty($media_id)) {
            throw new Exception('media_id 不能为空');
        }

        return $this->officialCustomSend([
            'touser'  => $to_user_openid,
            'msgtype' => 'mpnews',
            'mpnews'  => [
                'media_id' => $media_id,
            ],
        ]);
    }
}