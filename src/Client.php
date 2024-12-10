<?php

namespace RSHDSDK;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

class Client
{
    protected $baseURL = 'http://api.internal.rczy.work';

    protected $timeout = 25.0;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var bool
     */
    protected $close = false;

    /**
     * @param array $config
     */
    public function __construct($config)
    {
        $this->client = new \GuzzleHttp\Client($this->getOption($config));
    }

    /**
     * @param array $config
     * @return array
     */
    protected function getOption($config)
    {
        $ssl = $config['ssl'] ?? false;

        if ($ssl) {
            $option['verify'] = $this->getCACert();
        }

        $option['base_uri'] = $config['base_uri'] ?? $this->baseURL;
        $option['timeout'] = $config['timeout'] ?? $this->timeout;
        $option['headers'] = array_merge([
            'rshd-project-name' => $config['rshd_project_name'] ?? '',
            'rshd-project-key'  => $config['rshd_project_key'] ?? '',
        ], $config['headers'] ?? []);

        return $option;
    }

    protected function getCACert()
    {
        return './cacert.pem';
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

    /**
     * @param string $url
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function apiPostRequest($url, $data)
    {
        return $this->resultToArray($this->request('POST', '/index' . $url, $data));
    }

    /**
     * @param string $url
     * @return array
     * @throws Exception
     */
    public function apiGetRequest($url)
    {
        return $this->resultToArray($this->request('GET', '/index' . $url, []));
    }

    /**
     * @param string $url
     * @param string $file_path
     * @param string $oss_path
     * @return array
     * @throws Exception
     */
    public function apiPostFileRequest($url, $file_path, $oss_path)
    {
        return $this->resultToArray($this->request('FILE', '/index' . $url, [
            'multipart' => [
                [
                    'name'     => 'object_file',
                    'contents' => fopen($file_path, 'r'),
                ],
                [
                    'name'     => 'object_path',
                    'contents' => $oss_path
                ],
            ]
        ]));
    }

    /**
     * 独立的 post 请求
     * @param string $url
     * @param array $data
     * @return string
     * @throws Exception
     */
    public static function post($url, $data, $option = [])
    {
        if (empty($url)) {
            throw new Exception('url 不能为空');
        }

        $client = new \GuzzleHttp\Client($option);

        try {
            $request = $client->request('POST',$url, [
                'form_params' => $data,
            ]);
        } catch (GuzzleException $exception) {
            throw new Exception($exception->getMessage());
        }

        return $request->getBody()->getContents();
    }

    /**
     * 独立的 get 请求
     * @param string $url
     * @param array $option
     * @return string
     * @throws Exception
     */
    public static function get($url, $option = [])
    {
        if (empty($url)) {
            throw new Exception('url 不能为空');
        }

        $client = new \GuzzleHttp\Client($option);

        try {
            $request = $client->request('GET',$url);
        } catch (GuzzleException $exception) {
            throw new Exception($exception->getMessage());
        }

        return $request->getBody()->getContents();
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $data
     * @return string
     * @throws Exception
     */
    public function request($method, $url, $data)
    {
        try {
            if ($method == 'GET') {
                $request = $this->client->request('GET', $url);
            } elseif ($method == 'FILE') {
                $request = $this->client->request('POST', $url, $data);
            } else {
                $request = $this->client->request('POST', $url, ['form_params' => $data]);
            }
        } catch (GuzzleException $e) {
            throw new Exception($e->getMessage());
        }

        if ($request->getStatusCode() !== 200) {
            throw new Exception('请求错误，服务器返回：' . $request->getStatusCode());
        }

        $result = $request->getBody()->getContents();

        if (empty($result)) {
            return '';
        }

        return $result;
    }
}