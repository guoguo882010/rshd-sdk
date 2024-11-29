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
        return Client::postRequest('/voice/isiText', ['file_url' => $file_url, 'call_back_url' => $call_back_url], $this->projectConfig);
    }

    /**
     * @param $task_id
     * @return array
     * @throws Exception
     */
    public function searchTask($task_id)
    {
        return Client::postRequest('/voice/isiSearch', ['task_id' => $task_id], $this->projectConfig);
    }
}