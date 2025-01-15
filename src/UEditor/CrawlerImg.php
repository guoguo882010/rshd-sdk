<?php

namespace RSHDSDK\UEditor;

use Exception;

/**
 * @since 2.6
 */
class CrawlerImg
{
    protected $source;

    protected $config;

    /**
     * @param array $params
     * @param array $ueditor_config
     * @throws Exception
     */
    public function __construct($params, $ueditor_config)
    {
        if (empty($ueditor_config)) {
            throw new Exception('params config 不能为空');
        }

        /* 上传配置 */
        $this->config = array(
            "pathFormat" => $ueditor_config['catcherPathFormat'],
            "maxSize"    => $ueditor_config['catcherMaxSize'],
            "allowFiles" => $ueditor_config['catcherAllowFiles'],
            "oriName"    => "remote.png"
        );
        $fieldName = $ueditor_config['catcherFieldName'];

        if (!isset($params[$fieldName])) {
            throw new Exception("$fieldName 不能为空");
        }

        $this->source = $params[$fieldName];

    }

    /**
     * 抓取远程图片
     * @return array
     */
    public function crawler()
    {
        $list = array();
        foreach ($this->source as $imgUrl) {
            $item = new Uploader($imgUrl, $this->config, null, "remote");
            $info = $item->getFileInfo();
            $list[] = array(
                "state"    => $info["state"],
                "url"      => $info["url"],
                "size"     => $info["size"],
                "title"    => htmlspecialchars($info["title"]),
                "original" => htmlspecialchars($info["original"]),
                "source"   => htmlspecialchars($imgUrl)
            );
        }

        /* 返回抓取数据 */
        return array(
            'state' => count($list) ? 'SUCCESS' : 'ERROR',
            'list'  => $list
        );
    }
}