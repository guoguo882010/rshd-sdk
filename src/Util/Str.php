<?php

namespace RSHDSDK\Util;

class Str
{
    /**
     * 根据微秒，生成一个独一无二的md5字符串
     * @return string
     */
    public static function generateUniqueMD5()
    {
        return md5(microtime(true));
    }

    /**
     * 生成一个16位长度的订单号
     * 生成的例子：49B98D875F19B4D0
     * @return string
     */
    public static function generateOrderNO()
    {
        // 获取当前时间戳
        $timestamp = microtime(true);  // 获取带有微秒的当前时间戳

        // 使用时间戳和随机数生成订单号
        return strtoupper(dechex($timestamp * 10000) . rand(1000, 9999));
    }

    /**
     * 生成一个20位长度的订单号
     * 例子：20250206101030567389
     * @return string
     */
    public static function generateDateOrderNumber() {
        // 获取当前时间的年月日时分秒，格式如：20250206103045
        $datetime = date("YmdHis");
        // 获取当前微秒（取后三位），确保在同一秒内的订单号也不同
        $micro = sprintf("%03d", (int)((microtime(true) - floor(microtime(true))) * 1000));
        // 生成一个3位随机数，进一步降低重复概率
        $rand = mt_rand(100, 999);
        // 拼接得到最终的订单号
        return $datetime . $micro . $rand;
    }

    /**
     * 获取文件扩展名 例：jpg
     * @param string $fileName
     * @return string
     */
    public static function getFileExtension($fileName)
    {
        return pathinfo($fileName, PATHINFO_EXTENSION);
    }
}