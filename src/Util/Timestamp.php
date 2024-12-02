<?php

namespace RSHDSDK\Util;

class Timestamp
{
    /**
     * 返回上个月得今天时间戳
     *
     * @return int
     */
    public static function lastMonthToday()
    {
        $time = \time();

        $today = date('d', $time); //获取今天的日期

        $one_day             = strtotime(date('Y-m-01', $time));        //本月一号
        $last_month          = date('m', strtotime('-1 day', $one_day));//获取上个月的月份
        $last_month_last_day = date('d', strtotime('-1 day', $one_day));//获取上个月的最后一天
        $last_month_year     = date('Y', strtotime('-1 day', $one_day));//获取上个月的年份

        //如果当前的日期大于上月的最后一天
        //比如当前是7月31日，上月最后一天是30日，那么直接返回6月30日的日期，不能返回6月31日
        //应为6月没有31日
        if ($today > $last_month_last_day) {
            return strtotime($last_month_year . '-' . $last_month . '-' . $last_month_last_day . '23:59:59');
        }

        return strtotime($last_month_year . '-' . $last_month . '-' . $today . '23:59:59');
    }

    /**
     * 返回今日开始和结束的时间戳
     *
     * @return array
     */
    public static function today()
    {
        return [
            mktime(0, 0, 0, date('m'), date('d'), date('Y')),
            mktime(23, 59, 59, date('m'), date('d'), date('Y')),
        ];
    }

    /**
     * 返回明天开始和结束的时间戳
     *
     * @return array
     */
    public static function tomorrow()
    {
        $start = strtotime(date('Y-m-d 0:0:0', strtotime("+1 days")));
        $end   = $start + 86400 - 1; //-1秒
        return [$start, $end];
    }

    /**
     * 返回后天开始和结束的时间戳
     *
     * @return array
     */
    public static function dayAfterTomorrow()
    {
        $start = strtotime(date('Y-m-d 0:0:0', strtotime("+2 days")));
        $end   = $start + 86400 - 1; //-1秒
        return [$start, $end];
    }

    /**
     * 返回昨日开始和结束的时间戳
     *
     * @return array
     */
    public static function yesterday()
    {
        $yesterday = date('d') - 1;
        return [
            mktime(0, 0, 0, date('m'), $yesterday, date('Y')),
            mktime(23, 59, 59, date('m'), $yesterday, date('Y')),
        ];
    }

    /**
     * 返回本周开始和结束的时间戳
     *
     * @return array
     */
    public static function week()
    {
        $timestamp = time();
        return [
            strtotime(date('Y-m-d', strtotime("+0 week Monday", $timestamp))),
            strtotime(date('Y-m-d', strtotime("+0 week Sunday", $timestamp))) + 24 * 3600 - 1,
        ];
    }

    /**
     * 返回上周开始和结束的时间戳
     *
     * @return array
     */
    public static function lastWeek()
    {
        $timestamp = time();
        return [
            strtotime(date('Y-m-d', strtotime("last week Monday", $timestamp))),
            strtotime(date('Y-m-d', strtotime("last week Sunday", $timestamp))) + 24 * 3600 - 1,
        ];
    }

    /**
     * 返回下周开始和结束的时间戳
     *
     * @return array
     */
    public static function nextWeek()
    {
        $start = strtotime(date('Y-m-d 0:0:0', strtotime("next week")));
        $end   = $start + 604800;
        return [$start, $end];
    }

    /**
     * 返回本月开始和结束的时间戳
     *
     * @return array
     */
    public static function month($everyDay = false)
    {
        return [
            mktime(0, 0, 0, date('m'), 1, date('Y')),
            mktime(23, 59, 59, date('m'), date('t'), date('Y')),
        ];
    }

    /**
     * 返回指定时间月份开始和结束的时间戳
     *
     * @param $time
     *
     * @return array
     */
    public static function dateMonth($time)
    {
        if (empty($time)) {
            $time = time();
        }
        return [
            mktime(0, 0, 0, date('m', $time), 1, date('Y', $time)),
            mktime(23, 59, 59, date('m', $time), date('t', $time), date('Y', $time)),
        ];
    }

    /**
     * 返回上个月（环比）开始和结束的时间戳
     *
     * @return array
     */
    public static function lastMonth()
    {
        $begin = mktime(0, 0, 0, date('m') - 1, 1, date('Y'));
        $end   = mktime(23, 59, 59, date('m') - 1, date('t', $begin), date('Y'));

        return [$begin, $end];
    }

    /**
     * 返回上个月得1号到上个月的今天时间戳
     * 例如：今天是3月15号，那么返回2月1号到2月15号时间戳
     *
     * @return array
     */
    public static function lastMonth1ToToday()
    {
        $start = mktime(0, 0, 0, date("n") - 1, 1);
        $end   = self::lastMonthToday();
        return [$start, $end];
    }

    /**
     * 返回下月开始和结束时间戳
     *
     * @return array
     */
    public static function nextMonth()
    {
        $begin = mktime(0, 0, 0, date("n") + 1, 1);
        $end   = mktime(23, 59, 59, date("n") + 1, date("t", $begin));

        return [$begin, $end];
    }

    /**
     * 返回今年开始和结束的时间戳
     *
     * @return array
     */
    public static function year()
    {
        return [
            mktime(0, 0, 0, 1, 1, date('Y')),
            mktime(23, 59, 59, 12, 31, date('Y')),
        ];
    }

    /**
     * 返回去年开始和结束的时间戳
     *
     * @return array
     */
    public static function lastYear()
    {
        $year = date('Y') - 1;
        return [
            mktime(0, 0, 0, 1, 1, $year),
            mktime(23, 59, 59, 12, 31, $year),
        ];
    }

    /**
     * 获取几天前零点到现在/昨日结束的时间戳
     *
     * @param int  $day 天数
     * @param bool $now 返回现在或者昨天结束时间戳
     *
     * @return array
     */
    public static function dayToNow($day = 1, $now = true)
    {
        $end = time();
        if (!$now) {
            list($foo, $end) = self::yesterday();
        }

        return [
            mktime(0, 0, 0, date('m'), date('d') - $day, date('Y')),
            $end,
        ];
    }

    /**
     * 返回几天前的时间戳
     *
     * @param int $day
     *
     * @return int
     */
    public static function daysAgo($day = 1)
    {
        $nowTime = time();
        return $nowTime - self::daysToSecond($day);
    }

    /**
     * 返回几天后的时间戳
     *
     * @param int $day
     *
     * @return int
     */
    public static function daysAfter($day = 1)
    {
        $nowTime = time();
        return $nowTime + self::daysToSecond($day);
    }

    /**
     * 天数转换成秒数
     *
     * @param int $day
     *
     * @return int
     */
    public static function daysToSecond($day = 1)
    {
        return $day * 86400;
    }

    /**
     * 周数转换成秒数
     *
     * @param int $week
     *
     * @return int
     */
    public static function weekToSecond($week = 1)
    {
        return self::daysToSecond() * 7 * $week;
    }

    /**
     * 给定一个日期（例：2021-02-13）返回这个日期的开始-结束时间戳
     *
     * @param $date
     *
     * @return array
     */
    public static function dateToTimestamp($date)
    {
        return [
            strtotime($date . ' 0:0:0'),
            strtotime($date . ' 08:00:00'),
        ];
    }

    /**
     * 获取当前月1-7号的时间戳
     * @return array
     */
    public static function currentMonthFirstSevenDay($time = null)
    {
        if (empty($time)) {
            $time = time();
        }
        return [mktime(0, 0, 0, date('m',$time), 1, date('Y',$time)), mktime(23, 59, 59, date('m',$time), 7, date('Y',$time))];
    }

    /**
     * 获取当前月8-14号的时间戳
     * @return array
     */
    public static function currentMonthSecondSevenDay($time = null)
    {
        if (empty($time)) {
            $time = time();
        }
        return [mktime(0, 0, 0, date('m',$time), 8, date('Y',$time)), mktime(23, 59, 59, date('m',$time), 14, date('Y',$time))];
    }

    /**+
     * 获取当前月15-21号的时间戳
     * @return array
     */
    public static function currentMonthThirdSevenDay($time = null)
    {
        if (empty($time)) {
            $time = time();
        }
        return [mktime(0, 0, 0, date('m',$time), 15, date('Y',$time)), mktime(23, 59, 59, date('m',$time), 21, date('Y',$time))];
    }

    /**+
     * 获取当前月21-当前月最后一天，的时间戳
     * @return array
     */
    public static function currentMonthFourthSevenDay($time = null)
    {
        if (empty($time)) {
            $time = time();
        }
        return [mktime(0, 0, 0, date('m',$time), 22, date('Y',$time)), mktime(23, 59, 59, date('m',$time), date("t",$time), date('Y',$time))];
    }

    /**
     * 返回指定日期当天开始和结束时间戳数组或当月开始和结束的时间戳数组
     *
     * @param        $date
     * @param string $type
     *
     * @return array|false
     */
    public static function getDateStartToEnd($date, string $type = 'month')
    {
        if ($type == 'month') {
            $time = strtotime($date);
            return [mktime(0, 0, 0, date('m', $time), 1, date('Y', $time)), mktime(23, 59, 59, date('m', $time), date("t", $time), date('Y', $time))];
        } elseif ($type == 'day') {
            $time = strtotime($date);
            return [$time, $time + 86399];
        }
        return false;
    }

    /**
     * 获取一个月的时间，离当前月之前的一个月，之间间隔几个月
     * 例如：当前月2023-02之前的月份是2023-01，传入需要计算的月份为2022-03
     * 最后的结果为 abs（2022-2023） * 12 + （01 - 03）= 10
     *
     * @param $month
     *
     * @return int
     */
    public static function getMonthNum($month)
    {
        $date1 = explode('-', $month);
        $date2 = explode('-', date('Y-m', strtotime('-1 month')));

        return abs($date1[0] - $date2[0]) * 12 + ($date2[1] - $date1[1]);
    }

    /**
     * 计算两个日期之间的月份差
     *
     * @param $startDate
     * @param $endDate
     *
     * @return float|int|mixed|string
     */
    public static function dateMonthDiff($startDate, $endDate)
    {
        $date1 = explode('-', $startDate);
        $date2 = explode('-', $endDate);

        return abs($date1[0] - $date2[0]) * 12 + ($date2[1] - $date1[1]);
    }

    /**+
     * 是否时间戳
     *
     * @param $time
     *
     * @return bool
     */
    public static function isTimestamp($time = null)
    {

        if (is_numeric($time) &&
            $time > 0 &&
            (strlen($time) == 9 || strlen($time) == 10) &&
            preg_match('/^[1-9]\d{8,9}$/', $time)) {

            return true;
        }
        return false;
    }

    /**
     * 获取指定开始年月到结束年月中间的月份数组
     *
     * @param        $end_year
     * @param        $end_month
     * @param string $start_year
     * @param string $start_month
     *
     * @return array
     */
    public static function getStartMonthToEndMonth($end_year, $end_month,  $start_year = '2023', $start_month = '01')
    {
        $start     = $start_year;
        $years     = [];
        $month_arr = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        while ($start <= $end_year) {
            $years[] = intval($start);
            $start   = $start + 1;
        }

        $months = [];
        foreach ($years as $year) {
            foreach ($month_arr as $month) {
                if ($start_year == $year && $end_year == $year) {
                    if ($month >= $start_month && $month <= $end_month) {
                        $months[] = $year . '-' . $month;
                    }
                } else
                    if ($start_year == $year) {
                        if ($month >= $start_month) {
                            $months[] = $year . '-' . $month;
                        }
                    } elseif ($year < $end_year && $year > $start_year) {
                        $months[] = $year . '-' . $month;
                    } elseif ($end_year == $year) {
                        if ($month <= $end_month) {
                            $months[] = $year . '-' . $month;
                        }
                    }
            }
        }
        return $months;
    }
}