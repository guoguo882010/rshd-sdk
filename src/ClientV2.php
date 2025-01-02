<?php

namespace RSHDSDK;

use Exception;
use RSHDSDK\Util\HTTP;

class ClientV2
{
    protected $baseURL = 'http://api.internal.rczy.work';

    protected $timeout = 15;

    /**
     * @var bool
     */
    protected $close = false;

    protected $header = [];

    public function __construct($config)
    {
        if (!empty($config['close'])) {
            $this->close = $config['close'];
        }

        if (!empty($config['base_uri'])) {
            $this->baseURL = $config['base_uri'];
        }

        if (!empty($config['timeout'])) {
            $this->timeout = $config['timeout'];
        }

        $this->header[] = 'rshd-project-name:' . $config['rshd_project_name'] ?? '';
        $this->header[] = 'rshd-project-key:' . $config['rshd_project_key'] ?? '';
    }

    /**
     * @param string $url
     * @param array $body
     * @return array
     * @throws Exception
     */
    public function apiPostRequest($url, $body)
    {
        return $this->resultToArray(HTTP::sendPostRequest($this->baseURL . '/index' . $url, $this->header, $body, $this->timeout));
    }

    /**
     * 服务器返回的 json 结果 转换为 数组
     * @param string $result
     * @return array
     */
    protected function resultToArray($result)
    {
        if ($this->close) {
            return [
                'status' => 200,
                'message' => '',
                'data' => [],
            ];
        }

        if (empty($result)) {
            return [];
        }

        return json_decode($result, true);
    }
}