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
        return Client::postRequest('/ip/add', ['ip' => $ip], $this->projectConfig);
    }

    /**
     * 查找ip
     * @param string $ip
     * @return array
     * @throws Exception
     */
    public function find($ip)
    {
        return Client::postRequest('/ip/find', ['ip' => $ip], $this->projectConfig);
    }
}