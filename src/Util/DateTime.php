<?php

namespace RSHDSDK\Util;

class DateTime
{
    /**
     * 获取当前日期+时间
     * @return string
     */
    public static function currentDateTime()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * 获取今天的开始，结束时间
     * @return array
     */
    public static function today()
    {
        return [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')];
    }

    /**
     * 明天
     * @return array
     */
    public static function tomorrow()
    {
        return [date('Y-m-d 00:00:00', strtotime('+1 day')),
            date('Y-m-d 23:59:59', strtotime('+1 day'))];
    }

    /**
     * 后天
     * @return array
     */
    public static function dayAfterTomorrow()
    {
        return [date('Y-m-d 00:00:00', strtotime('+2 day')),
            date('Y-m-d 23:59:59', strtotime('+2 day'))];
    }

    /**
     * 昨天
     * @return array
     */
    public static function yesterday()
    {
        return [date('Y-m-d 00:00:00', strtotime('-1 day')),
            date('Y-m-d 23:59:59', strtotime('-1 day'))];
    }

    /**
     * 本月开始，结束时间
     * @return array
     */
    public static function month()
    {
        return [date('Y-m-1 00:00:00'),
            date('Y-m-t 23:59:59')];
    }

    /**
     * 未来30天
     * 例：今天5月7日，返回 2024-05-07 00:00:00 到 2024-06-07 23:59:59
     * @return array
     */
    public static function next30Days()
    {
        return [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59', strtotime('+1 month'))];
    }

    /**
     * 未来90天（三个月）
     * @return array
     */
    public static function next90Days()
    {
        return [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59', strtotime('+3 month'))];
    }

    /**
     * 未来180天（半年）
     * @return array
     */
    public static function next180Days()
    {
        return [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59', strtotime('+6 month'))];
    }

    /**
     * 过去30天
     * 例：今天5月7日，返回 2024-04-07 00:00:00 到 2024-05-07 23:59:59
     * @return array
     */
    public static function last30Days()
    {
        return [date('Y-m-d 00:00:00', strtotime('-1 month')),date('Y-m-d 23:59:59')];
    }

    /**
     * 过去60天
     * @return array
     */
    public static function last60Days()
    {
        return [date('Y-m-d 00:00:00', strtotime('-2 month')),date('Y-m-d 23:59:59')];
    }

    /**
     * 过去180天
     * @return array
     */
    public static function last180Days()
    {
        return [date('Y-m-d 00:00:00', strtotime('-6 month')),date('Y-m-d 23:59:59')];
    }

    /**
     * 上月开始，结束时间
     * @return array
     */
    public static function lastMonth()
    {
        return [date('Y-m-1 00:00:00',strtotime('last month')),
            date('Y-m-t 23:59:59',strtotime('last month'))];
    }

    /**
     * 返回上个月得1号到上个月的今天时间戳，上月同比
     * 例如：今天是3月15号，那么返回2月1号到2月15号时间戳
     * @return array
     */
    public static function onLastMonth()
    {
        return [date('Y-m-1 00:00:00', strtotime('last month')),
            date('Y-m-d 23:59:59', Timestamp::lastMonthToday())];
    }

    /**
     * 给定一个日期，返回这天的开始和结束时间
     * @param string $date
     * @return array
     */
    public static function getDateStartAndEndTime($date)
    {
        return [date('Y-m-d 00:00:00',strtotime($date)),
            date('Y-m-d 23:59:59',strtotime($date))];
    }
}