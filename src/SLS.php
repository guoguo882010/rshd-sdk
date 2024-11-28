<?php

namespace RSHD\RSHDSDK;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

class SLS extends Project
{
    /**
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function putRequest($data)
    {
        return Client::postRequest('/log/slsPut', [
            'topic' => 'Request',
            'data'  => json_encode($data, JSON_UNESCAPED_UNICODE),
        ], $this->projectName);
    }

    /**
     * @param Exception $e
     * @return array
     * @throws GuzzleException
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
        ], $this->projectName);
    }
}