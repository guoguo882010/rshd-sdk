<?php

namespace RSHDSDK;

use Exception;

class SLS extends Project
{
    /**
     * @param array $data 日志数据
     * @param string $topic 日志主题
     * @return array
     * @throws Exception
     */
    public function putData($data, $topic)
    {
        return Client::postRequest('/log/slsPut', [
            'topic' => $topic,
            'data'  => json_encode($data, JSON_UNESCAPED_UNICODE),
        ], $this->projectConfig);
    }

    /**
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function putRequest($data)
    {
        return Client::postRequest('/log/slsPut', [
            'topic' => 'Request',
            'data'  => json_encode($data, JSON_UNESCAPED_UNICODE),
        ], $this->projectConfig);
    }

    /**
     * @param Exception $e
     * @return array
     * @throws Exception
     */
    public function putException(Exception $e)
    {
        return Client::postRequest('/log/slsPut', [
            'topic' => 'Exception',
            'data'  => json_encode([
                '_exception_name'    => get_class($e),
                '_exception_message' => $e->getMessage(),
                '_exception_file'    => $e->getFile(),
                '_exception_line'    => $e->getLine(),
                '_exception_trace'   => $e->getTrace(),
            ], JSON_UNESCAPED_UNICODE),
        ], $this->projectConfig);
    }
}