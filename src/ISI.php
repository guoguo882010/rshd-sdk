<?php

namespace RSHDSDK;

use Exception;

class ISI extends Project
{
    /**
     * @param $file_url
     * @param $call_back_url
     * @return array
     * @throws Exception
     */
    public function getText($file_url, $call_back_url)
    {
        return $this->client->apiPostRequest('/voice/isiText', ['file_url' => $file_url, 'call_back_url' => $call_back_url]);
    }

    /**
     * @param $task_id
     * @return array
     * @throws Exception
     */
    public function searchTask($task_id)
    {
        return $this->client->apiPostRequest('/voice/isiSearch', ['task_id' => $task_id]);
    }
}