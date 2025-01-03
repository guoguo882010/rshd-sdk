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
        if (empty($nonce) || empty($associated_data) || empty($ciphertext)) {
            throw new Exception('缺少必要的参数');
        }

        return $this->client->apiPostRequest('/we_chat/decodeCallBack', [
            'nonce'           => $nonce,
            'associated_data' => $associated_data,
            'ciphertext'      => $ciphertext,
        ]);
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
}