<?php

namespace RSHDSDK;

use Exception;

abstract class SDKFacade
{
    /**
     * 配置文件
     * @return array
     */
    protected static function getProjectConfig()
    {
        return [];
    }

    /**
     * @param array $data
     * @return void
     * @throws Exception
     */
    public static function slsPutRequest($data)
    {
        SLS::instance(self::getProjectConfig())->putRequest($data);
    }

    /**
     * @param Exception $e
     * @return void
     * @throws Exception
     */
    public static function slsPutException(Exception $e)
    {
        SLS::instance(self::getProjectConfig())->putException($e);
    }

    /**
     * @param array $data
     * @param string $topic
     * @return void
     * @throws Exception
     */
    public static function slsPutData($data, $topic)
    {
        SLS::instance(self::getProjectConfig())->putData($data, $topic);
    }

    /**
     * @param string $object_path
     * @param string $mode fixed，lfit
     * @param integer $width
     * @param integer $height
     * @return string
     * @throws Exception
     */
    public static function ossGetPicSignUrl($object_path, $mode = 'fixed', $width = 200, $height = 200)
    {
        $result = OSS::instance(self::getProjectConfig())->getPicSignUrl($object_path, $mode, $width, $height);

        if ($result['status'] !== 200) {
            throw new Exception($result['message']);
        }

        return $result['data']['url'] ?? '';
    }

    /**
     * @param string $object_path
     * @return string
     * @throws Exception
     */
    public static function ossGetSignUrl($object_path)
    {
        $result = OSS::instance(self::getProjectConfig())->getSignUrl($object_path);

        if ($result['status'] !== 200) {
            throw new Exception($result['message']);
        }

        return $result['data']['url'] ?? '';
    }

    /**
     * @param string $file_path
     * @param string $object_path
     * @return string
     * @throws Exception
     */
    public static function ossUploadFile($file_path, $object_path)
    {
        $result = OSS::instance(self::getProjectConfig())->uploadFile($file_path, $object_path);

        if ($result['status'] !== 200) {
            throw new Exception($result['message']);
        }

        return $object_path;
    }

    /**
     * 查询oss文件是否存在
     * @param string $object_path
     * @return bool true存在 false不存在
     * @throws Exception
     */
    public static function ossObjectExist($object_path)
    {
        $result = OSS::instance(self::getProjectConfig())->objectExist($object_path);

        if ($result['status'] !== 200) {
            return false;
        }

        return true;
    }

    /**
     * @param string $telephone
     * @param string $message
     * @return true
     * @throws Exception
     */
    public static function smsSendESMS100($telephone, $message)
    {
        $result = SMS::instance(self::getProjectConfig())->sendESMS100($telephone, $message);

        if ($result['status'] !== 200) {
            throw new Exception($result['message']);
        }

        return true;
    }

    /**
     * @param string $telephone
     * @param string $template_id
     * @param array $template_param
     * @return true
     * @throws Exception
     */
    public static function smsSendAliyun($telephone, $template_id, $template_param)
    {
        $result = SMS::instance(self::getProjectConfig())->sendAliyun($telephone, $template_id, $template_param);

        if ($result['status'] !== 200) {
            throw new Exception($result['message']);
        }

        return true;
    }

    /**
     * @param string $telephone
     * @param string $template_id
     * @param array $template_param
     * @return true
     * @throws Exception
     */
    public static function smsSendBaidu($telephone, $template_id, $template_param)
    {
        $result = SMS::instance(self::getProjectConfig())->sendBaidu($telephone, $template_id, $template_param);

        if ($result['status'] !== 200) {
            throw new Exception($result['message']);
        }

        return true;
    }

    /**
     * @param string $ip
     * @return true
     * @throws Exception
     */
    public static function ipAdd($ip)
    {
        $result = IP::instance(self::getProjectConfig())->add($ip);

        if ($result['status'] !== 200) {
            throw new Exception($result['message']);
        }

        return true;
    }

    /**
     * @param string $ip
     * @return bool
     * @throws Exception
     */
    public static function ipFind($ip)
    {
        $result = IP::instance(self::getProjectConfig())->find($ip);

        if ($result['status'] !== 200) {
            return false;
        }

        return true;
    }

    /**
     * @return string[]
     */
    public static function getRobotRequest()
    {
        return [
            '_request_user' => 'robot',
            '_request_id'   => ''
        ];
    }
}