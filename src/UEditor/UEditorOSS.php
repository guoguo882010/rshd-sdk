<?php

namespace RSHDSDK\UEditor;

use Exception;
use RSHDSDK\OSS;

/**
 * @since 2.6
 */
class UEditorOSS
{
    /**
     * @var array
     */
    protected $projectConfig;

    /**
     * @param array $projectConfig
     * @throws Exception
     */
    public function __construct($projectConfig)
    {
        if (empty($projectConfig)) {
            throw new Exception('projectConfig 项目配置文件不能为空');
        }

        $this->projectConfig = $projectConfig;
    }

    /**
     * @param string $object_path
     * @return string
     * @throws Exception
     */
    public function ossGetSignUrl($object_path)
    {
        $result = OSS::instance($this->projectConfig)->getSignUrl($object_path);

        if ($result['status'] !== 200) {
            throw new Exception($result['message']);
        }

        return $result['data']['url'] ?? '';
    }

    /**
     * @param $file_path
     * @param $object_path
     * @return string
     * @throws Exception
     */
    public function ossUploadFile($file_path, $object_path)
    {
        $result = OSS::instance($this->projectConfig)->uploadFile($file_path, $object_path);

        if ($result['status'] !== 200) {
            throw new Exception($result['message']);
        }

        return $object_path;
    }

    /**
     * @param string $object_path
     * @return bool
     * @throws Exception
     */
    public function ossObjectExist($object_path)
    {
        $result = OSS::instance($this->projectConfig)->objectExist($object_path);

        if ($result['status'] !== 200) {
            return false;
        }

        return true;
    }
}