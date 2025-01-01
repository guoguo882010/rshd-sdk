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
}