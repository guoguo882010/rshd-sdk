<?php

namespace RSHDSDK\Util;

use CURLFile;
use Exception;

class HTTP
{
    /**
     * @param string $url
     * @param array $headers
     * @param array $body
     * @param int $timeout
     * @param bool $ssl
     * @return string
     * @throws Exception
     */
    public static function sendPostRequest($url, $headers = [], $body = [], $timeout = 15, $ssl = false)
    {
        $result = self::sendRequest($url, 'POST', $headers, $body, $timeout, $ssl);

        if ($result['status_code'] !== 200) {
            throw new Exception('请求错误，服务器返回状态码：' . $result['status_code']);
        }

        if ($result['error']) {
            throw new Exception('请求错误：' . $result['message']);
        }

        return $result['response'];
    }

    /**
     * @param string $url
     * @param array $headers
     * @param array $body
     * @param int $timeout
     * @param bool $ssl
     * @return string
     * @throws Exception
     */
    public static function sendGetRequest($url, $headers = [], $body = [], $timeout = 15, $ssl = false)
    {
        $result = self::sendRequest($url, 'GET', $headers, $body, $timeout, $ssl);

        if ($result['status_code'] !== 200) {
            throw new Exception('请求错误，服务器返回状态码：' . $result['status_code']);
        }

        if ($result['error']) {
            throw new Exception('请求错误：' . $result['message']);
        }

        return $result['response'];
    }

    /**
     * 使用 cURL 发起 HTTP 请求
     * @param string $url 请求的 URL
     * @param string $method 请求方法 (GET 或 POST)
     * @param array $headers 可选的请求头数组
     * @param array|string $body 可选的请求数据
     * @param int $timeout 超时时间，默认 15 秒
     * @param bool $ssl 是否使用 ssl 请求 url
     * @return array 返回响应结果和 HTTP 状态码
     */
    public static function sendRequest($url, $method = 'POST', $headers = [], $body = [], $timeout = 15, $ssl = false) {
        // 初始化 cURL
        $ch = curl_init();

        // 确保方法是大写
        $method = strtoupper($method);

        // 配置 cURL 选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // 返回响应字符串而非直接输出
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);     // 设置超时时间

        if ($ssl) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // 启用证书验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);    // 验证主机名
            curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '\cacert.pem');    // 指定自签名证书文件
        }

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);        // 设置 POST 请求

            // 检查是否有文件上传
            $hasFile = false;
            if (is_array($body)) {
                foreach ($body as $key => $value) {
                    //上传文件路径已 @ 开头
                    if (is_string($value) && strpos($value, '@') === 0 && file_exists(substr($value, 1))) {
                        $body[$key] = new CURLFile(substr($value, 1));
                        $hasFile = true;
                    }
                }
            }

            // 如果有文件上传，直接传递数组；否则处理为 x-www-form-urlencoded
            if (!$hasFile && is_array($body)) {
                $body = http_build_query($body);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        } elseif ($method === 'GET') {
            if (!empty($body) && is_array($body)) {
                $query = http_build_query($body);
                $url .= (strpos($url, '?') === false ? '?' : '&') . $query;
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); // 支持其他方法，如 PUT、DELETE

            if (!empty($body)) {
                if (is_array($body)) {
                    $body = http_build_query($body);
                }
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            }
        }

        // 设置请求头
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($ch, CURLOPT_HEADER,0);//1 显示响应头信息，一般调试用

        // 执行请求并获取响应
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // 获取 HTTP 状态码

        // 检查是否有错误
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return [
                'error' => true,
                'message' => $error,
                'status_code' => $httpCode
            ];
        }

        // 关闭 cURL
        curl_close($ch);

        return [
            'error' => false,
            'response' => $response,
            'status_code' => $httpCode
        ];
    }

}