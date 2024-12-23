<?php

namespace RSHDSDK;

use Exception;

class Tel extends Project
{
    /**
     * 获取电话号码归属地
     * 返回数组,查看接口 /tel/address
     * @param string $tel
     * @return array
     * @throws Exception
     */
    public function getAddress($tel)
    {
        if (empty($tel)) {
            throw new Exception('电话不能为空');
        }

        return $this->client->apiPostRequest('/tel/address', ['tel' => $tel]);
    }
}