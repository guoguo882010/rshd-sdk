<?php

namespace RSHD\RSHDSDK;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

class Client
{
    const BASE_URL = 'http://tt.245.35jkw.com';

    const TIMEOUT = 25.0;

    /**
     * @param string $url
     * @param array $data
     * @param string $project_name
     * @return array
     * @throws GuzzleException
     */
    public static function postRequest($url, $data, $project_name)
    {
        return self::request('POST', $url, $data, $project_name);
    }

    /**
     * @param string $url
     * @param string $file_path
     * @param string $oss_path
     * @param string $project_name
     * @return array
     * @throws GuzzleException
     */
    public static function postFileRequest($url, $file_path, $oss_path, $project_name)
    {

        return self::request('FILE', $url, [
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
        ], $project_name);
    }

    /**
     * @param string $url
     * @param string $project_name
     * @return array
     * @throws GuzzleException
     */
    public static function getRequest($url, $project_name)
    {
        return self::request('GET', $url, [], $project_name);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $data
     * @param string $project_name
     * @return mixed
     * @throws GuzzleException
     * @throws Exception
     */
    protected static function request($method, $url, $data, $project_name)
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => self::BASE_URL,
            'timeout'  => self::TIMEOUT,
            'headers'  => ['rshd-project-name' => $project_name],
        ]);

        if ($method == 'GET') {
            $request = $client->request($method, '/index' . $url);
        } elseif ($method == 'FILE') {
            $request = $client->request($method, '/index' . $url, $data);
        } else {
            $request = $client->request($method, '/index' . $url, ['form_params' => $data]);
        }

        if ($request->getStatusCode() !== 200) {
            throw new Exception('请求错误，服务器返回：' . $request->getStatusCode());
        }

        $result = $request->getBody()->getContents();

        if (empty($result)) {
            throw new Exception('服务器返回空数据');
        }

        $json_arr = json_decode($result, true);

        if ($json_arr['status'] !== 200) {
            throw new Exception($json_arr['message']);
        }

        return $json_arr;
    }

}