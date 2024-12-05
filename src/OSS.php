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
        return $this->client->apiPostRequest('/store/ossSignUrl', ['object_path' => $object_path]);
    }

    /**
     * @param string $file_path
     * @param string $oss_path
     * @return array
     * @throws Exception
     */
    public function uploadFile($file_path, $oss_path)
    {
        return $this->client->apiPostFileRequest('/store/ossUploadFile', $file_path, $oss_path);
    }

    /**
     * @param string $content
     * @param string $oss_path
     * @return array
     * @throws Exception
     */
    public function uploadContent($content, $oss_path)
    {
        return $this->client->apiPostRequest('/store/ossUploadContent', ['object_path' => $oss_path, 'object_content' => $content]);
    }

    /**
     * @param string $oss_path
     * @param array $options
     * @return array
     * @throws Exception
     */
    public function getObjectContent($oss_path, $options = null)
    {
        $data['object_path'] = $oss_path;

        if (!empty($options) && is_array($options)) {
            $data['options'] = json_encode($options, JSON_UNESCAPED_UNICODE);
        }

        return $this->client->apiPostRequest('/store/ossObjectContent', $data);
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
        return $this->client->apiPostRequest('/store/ossPicSignUrl', [
            'object_path' => $oss_path,
            'mode'        => $mode,
            'width'       => $width,
            'height'      => $height,
        ]);
    }

    /**
     * 判断文件是否存在
     * @param string $oss_path
     * @return array
     * @throws Exception
     */
    public function objectExist($oss_path)
    {
        return $this->client->apiPostRequest('/store/ossObjectExist', [
            'object_path' => $oss_path,
        ]);
    }
}