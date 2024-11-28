<?php

namespace RSHD\RSHDSDK;

use GuzzleHttp\Exception\GuzzleException;

class OSS extends Project
{
    /**
     * @param string $object_path
     * @return array
     * @throws GuzzleException
     */
    public function getSignUrl($object_path)
    {
        return Client::postRequest('/store/ossSignUrl', ['object_path' => $object_path], $this->projectName);
    }

    /**
     * @param string $file_path
     * @param string $oss_path
     * @return array
     */
    public function uploadFile($file_path, $oss_path)
    {
        return Client::postFileRequest('/store/ossUploadFile', $file_path, $oss_path, $this->projectName);
    }

    /**
     * @param string $content
     * @param string $oss_path
     * @return array
     * @throws GuzzleException
     */
    public function uploadContent($content, $oss_path)
    {
        return Client::postRequest('/store/ossUploadContent', ['object_path' => $oss_path, 'object_content' => $content], $this->projectName);
    }

    /**
     * @param string $oss_path
     * @return array
     * @throws GuzzleException
     */
    public function getObjectContent($oss_path)
    {
        return Client::postRequest('/store/ossObjectContent', ['object_path' => $oss_path], $this->projectName);
    }

    /**
     * @param string $oss_path
     * @param string $mode
     * @param int $width
     * @param int $height
     * @return array
     * @throws GuzzleException
     */
    public function getPicSignUrl($oss_path, $mode = 'fixed', $width = 200, $height = 200)
    {
        return Client::postRequest('/store/ossPicSignUrl', [
            'object_path' => $oss_path,
            'mode'        => $mode,
            'width'       => $width,
            'height'      => $height,
        ], $this->projectName);
    }
}