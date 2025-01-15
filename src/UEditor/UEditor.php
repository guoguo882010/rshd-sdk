<?php

namespace RSHDSDK\UEditor;

use Exception;

/**
 * @since 2.6
 */
class UEditor
{
    /**
     * @var UEditorOSS
     */
    protected $oss;

    /**
     * @param array $projectConfig
     * @throws Exception
     */
    public function __construct($projectConfig)
    {
        if (empty($projectConfig)) {
            throw new Exception('项目配置文件不能为空');
        }

        $this->oss = new UEditorOSS($projectConfig);
    }

    /**
     * @param array $param
     * @return array
     * @throws Exception
     */
    public function action($param)
    {
        $action = $param['action'] ?? '';

        if (empty($action)) {
            throw new Exception('参数传递错误');
        }

        $config = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(__DIR__ . "/config.json")), true);

        switch ($action) {
            case 'config':
                $result = $config;
                break;

            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $result = (new UploadImg($action, $config))->uploadFile($this->oss);
                break;

            /* 列出图片 */
            case 'listimage':
                /* 列出文件 */
            case 'listfile':
                $result = (new ListFile($param, $config))->getList();
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = (new CrawlerImg($param,$config))->crawler();
                break;

            default:
                $result = array(
                    'state' => '请求地址出错'
                );
                break;
        }

        return $result;
    }

    /**
     * 保存 HTML 时处理 IMG 标签的 src
     *
     * @param string $html 原始 HTML 字符串
     * @return string 处理后的 HTML
     */
    public function setHtml($html)
    {
        // 使用正则表达式提取并替换 src
        return preg_replace_callback(
            '/<img[^>]+src="([^"]+)"[^>]*>/i',
            function ($matches) {
                $url = $matches[1];

                // 仅处理包含 5biyela.com 或 aliyuncs.com 的 URL
                if (strpos($url, '5biyela.com') !== false || strpos($url, 'aliyuncs.com') !== false) {
                    // 去除域名和 "?" 后的内容
                    $relativePath = preg_replace('/^.*?ueditor\/(.*?)(\?.*)?$/', 'ueditor/$1', $url);
                    return str_replace($matches[1], $relativePath, $matches[0]);
                }

                // 不包含指定域名的 URL 原样返回
                return $matches[0];
            },
            $html
        );
    }

    /**
     * 读取 HTML 时将以 ueditor 开头的相对路径替换为完整 URL
     *
     * @param string $html 保存后的 HTML
     * @return string 处理后的 HTML
     * @throws Exception
     */
    public function getHtml($html)
    {
        // 使用正则表达式提取并替换 src
        return preg_replace_callback(
            '/<img[^>]+src="([^"]+)"[^>]*>/i',
            function ($matches) {
                $relativePath = $matches[1];
                // 仅处理以 ueditor 开头的路径

                if (strpos($relativePath, 'ueditor/') === 0) {
                    if ($this->oss->ossObjectExist($relativePath)) {
                        $fullUrl = $this->oss->ossGetSignUrl($relativePath);
                        return str_replace($matches[1], $fullUrl, $matches[0]);
                    }
                    //图片不存在
                    return str_replace($matches[1], '/static/index/images/404.png', $matches[0]);
                }
                // 非 ueditor 开头的路径，保持不变
                return $matches[0];
            },
            $html
        );
    }
}