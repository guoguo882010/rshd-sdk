<?php

namespace RSHDSDK;

use Exception;

class OSS extends Project
{
    /**
     * @param string $object_path
     * @return array
     * @throws Exception
     */
    public function getSignUrl($object_path)
    {
        return Client::postRequest('/store/ossSignUrl', ['object_path' => $object_path], $this->projectConfig);
    }

    /**
     * @param string $file_path
     * @param string $oss_path
     * @return array
     * @throws Exception
     */
    public function uploadFile($file_path, $oss_path)
    {
        return Client::postFileRequest('/store/ossUploadFile', $file_path, $oss_path, $this->projectConfig);
    }

    /**
     * @param string $content
     * @param string $oss_path
     * @return array
     * @throws Exception
     */
    public function uploadContent($content, $oss_path)
    {
        return Client::postRequest('/store/ossUploadContent', ['object_path' => $oss_path, 'object_content' => $content], $this->projectConfig);
    }

    /**
     * @param string $oss_path
     * @return array
     * @throws Exception
     */
    public function getObjectContent($oss_path)
    {
        return Client::postRequest('/store/ossObjectContent', ['object_path' => $oss_path], $this->projectConfig);
    }

    /**
     * @param string $oss_path
     * @param string $mode
     * @param int $width
     * @param int $height
     * @return array
     * @throws Exception
     */
    public function getPicSignUrl($oss_path, $mode = 'fixed', $width = 200, $height = 200)
    {
        return Client::postRequest('/store/ossPicSignUrl', [
            'object_path' => $oss_path,
            'mode'        => $mode,
            'width'       => $width,
            'height'      => $height,
        ], $this->projectConfig);
    }

    /**
     * 判断文件是否存在
     * @param string $oss_path
     * @return array
     * @throws Exception
     */
    public function objectExist($oss_path)
    {
        return Client::postRequest('/store/ossObjectExist', [
            'object_path' => $oss_path,
        ], $this->projectConfig);
    }
}