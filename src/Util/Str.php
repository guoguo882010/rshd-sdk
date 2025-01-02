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
     * 获取文件扩展名 例：jpg
     * @param string $fileName
     * @return string
     */
    public static function getFileExtension($fileName)
    {
        return pathinfo($fileName, PATHINFO_EXTENSION);
    }
}