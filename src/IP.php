<?php

namespace RSHDSDK;


use Exception;

class IP extends Project
{
    /**
     * 添加ip
     * @param string $ip
     * @return array
     * @throws Exception
     */
    public function add($ip)
    {
        return $this->client->apiPostRequest('/ip/add', ['ip' => $ip]);
    }

    /**
     * 查找ip
     * @param string $ip
     * @return array
     * @throws Exception
     */
    public function find($ip)
    {
        return $this->client->apiPostRequest('/ip/find', ['ip' => $ip]);
    }
}