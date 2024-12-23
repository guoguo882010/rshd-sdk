<?php

namespace RSHDSDK;

use Exception;

class IdCard extends Project
{
    /**
     * 检测身份证、姓名是否一致
     * @param string $id_card
     * @param string $name
     * @return array
     * @throws Exception
     */
    public function check($id_card, $name)
    {
        if (empty($id_card) || empty($name)) {
            throw new Exception('身份证、姓名不能为空');
        }

        return $this->client->apiPostRequest('/id_card/check', ['id_card' => $id_card, 'name' => $name]);
    }
}