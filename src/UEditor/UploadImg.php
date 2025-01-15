<?php

namespace RSHDSDK\UEditor;

use Exception;

/**
 * @since 2.6
 */
class UploadImg
{
    protected $config;

    protected $fieldName;

    protected $base64 = 'upload';

    /**
     * @param string $action
     * @param array $ueditor_config
     * @throws Exception
     */
    public function __construct($action, $ueditor_config)
    {
        if (empty($action) || empty($ueditor_config)) {
            throw new Exception('action config 不能为空');
        }

        $this->init($action, $ueditor_config);
    }

    protected function init($action, $config)
    {
        switch ($action) {
            case 'uploadimage':
                $this->config = array(
                    "pathFormat" => $config['imagePathFormat'],
                    "maxSize"    => $config['imageMaxSize'],
                    "allowFiles" => $config['imageAllowFiles']
                );
                $this->fieldName = $config['imageFieldName'];
                break;
            case 'uploadscrawl':
                $this->config = array(
                    "pathFormat" => $config['scrawlPathFormat'],
                    "maxSize"    => $config['scrawlMaxSize'],
                    "allowFiles" => $config['scrawlAllowFiles'],
                    "oriName"    => "scrawl.png"
                );
                $this->fieldName = $config['scrawlFieldName'];
                $this->base64 = "base64";
                break;
            case 'uploadvideo':
                $this->config = array(
                    "pathFormat" => $config['videoPathFormat'],
                    "maxSize"    => $config['videoMaxSize'],
                    "allowFiles" => $config['videoAllowFiles']
                );
                $this->fieldName = $config['videoFieldName'];
                break;
            case 'uploadfile':
            default:
                $this->config = array(
                    "pathFormat" => $config['filePathFormat'],
                    "maxSize"    => $config['fileMaxSize'],
                    "allowFiles" => $config['fileAllowFiles']
                );
                $this->fieldName = $config['fileFieldName'];
                break;
        }
    }

    /**
     * @return array
     */
    public function uploadFile(UEditorOSS $oss)
    {
        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($this->fieldName, $this->config, $oss, $this->base64);

        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */

        /* 返回数据 */
        return $up->getFileInfo();
    }
}