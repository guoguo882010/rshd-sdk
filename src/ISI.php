<?php

namespace RSHDSDK;

use GuzzleHttp\Exception\GuzzleException;

class ISI extends Project
{
    /**
     * @param $file_url
     * @param $call_back_url
     * @return array
     * @throws GuzzleException
     */
    public function getText($file_url, $call_back_url)
    {
        return Client::postRequest('/voice/isiText', ['file_url' => $file_url, 'call_back_url' => $call_back_url], $this->projectConfig);
    }

    /**
     * @param $task_id
     * @return array
     * @throws GuzzleException
     */
    public function searchTask($task_id)
    {
        return Client::postRequest('/voice/isiSearch', ['task_id' => $task_id], $this->projectConfig);
    }
}