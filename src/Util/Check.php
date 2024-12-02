<?php

namespace RSHDSDK\Util;

use Exception;

class Check
{
    /**
     * 检测是不是逗号分割的id字符串，例：1,2,3,4
     * @param string $ids
     * @return bool
     */
    public static function isIdsStr($ids)
    {
        preg_match('/^[1-9]\d*(,[1-9]\d*)+$/', $ids, $output);

        if (count($output) == 2) {
            return true;
        }

        return false;
    }

    /**
     * 检测格式是否是 2024-04-14 23:12:12
     * @param string $dateTime
     * @return bool
     */
    public static function isDateTime($dateTime)
    {
        preg_match('/^(20\d\d)-((0[1-9])|(1[0-2]))-([0123][0-9]) (\d\d:\d\d:\d\d)$/', $dateTime, $output);

        if (count($output) > 0) {
            return true;
        }

        return false;
    }

    /**
     * 检测格式是否是 2024-04-14
     * @param string $date
     * @return bool
     */
    public static function isDate($date)
    {
        preg_match('/^(20\d\d)-((0[1-9])|(1[0-2]))-([0123][0-9])$/', $date, $output);

        if (count($output) > 0) {
            return true;
        }

        return false;
    }

    /**
     * 检测是否病历号
     *
     * @param string|null $number
     *
     * @return bool
     */
    public static function isCaseNumber(string $number = null): bool
    {
        if (empty($number)) {
            return false;
        }

        return (bool)preg_match('/^(2020|2021|2022|2023|2024|2025|2026|2027|2028|2029|2030)(01|02|03|04|05|06|07|08|09|10|11|12)(01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31)\d{2}$/', $number);
    }

    /**
     * 检测qq号
     *
     * @param string|null $number
     *
     * @return bool
     */
    public static function isQQNumber(string $number = null): bool
    {
        if (empty($number)) {
            return false;
        }

        return (bool)preg_match('/^[1-9]\d{7,10}$/', $number);
    }

    /**
     * 检测手机号
     *
     * @param string|null $number
     *
     * @return bool
     */
    public static function isMobileNumber(string $number = null): bool
    {
        if (empty($number)) {
            return false;
        }

        return (bool)preg_match('/^1[3456789]\d{9}$/', $number);
    }

    /**
     * 检测微信号是否正确
     * 微信号规则
     * （1）可使用6-20个字母、数字、下划线和减号。（2）必须以字母，下划线，中划线开头（字母不区分大小写）（3）不支持设置中文。
     *
     * @param string|null $number
     *
     * @return bool
     */
    public static function isWeixinNumber(string $number = null): bool
    {
        if (empty($number)) {
            return false;
        }

        return (bool)preg_match('/^[a-zA-Z_-][a-zA-Z\d_-]{5,19}$/', $number);
    }
}