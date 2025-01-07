<?php

namespace RSHDSDK;

use Exception;

/**
 * 快递查询
 */
class Express extends Project
{
    /**
     * 聚美快递查询
     * @param string $number
     * @return array
     * @throws Exception
     */
    public function juMei($number)
    {
        if (empty($number)) {
            throw new Exception('快递号不能为空');
        }

        return $this->client->apiPostRequest('/express/jumei', ['number' => $number]);
    }
}