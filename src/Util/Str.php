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
     * 生成一个订单号
     * @return string
     */
    public static function generateOrderNO()
    {
        return date('YmdHis').str_pad(mt_rand(1, 99999), 6, '0', STR_PAD_LEFT);
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