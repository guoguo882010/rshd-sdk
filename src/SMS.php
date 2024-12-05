<?php

namespace RSHDSDK;

use Exception;

class SMS extends Project
{

    /**
     * @param $telephone
     * @param $message
     * @return array
     * @throws Exception
     */
    public function sendESMS100($telephone, $message)
    {
        return $this->client->apiPostRequest('/sms/sms100', [
            'telephone' => $telephone,
            'message'   => $message,
        ]);
    }

    /**
     * @param string $telephone
     * @param string $template_id
     * @param array $template_param
     * @return array
     * @throws Exception
     */
    public function sendAliyun($telephone, $template_id, $template_param)
    {
        return $this->client->apiPostRequest('/sms/aliyun', [
            'telephone'      => $telephone,
            'template_id'    => $template_id,
            'template_param' => json_encode($template_param, JSON_UNESCAPED_UNICODE),
        ]);
    }

    /**
     * @param string $telephone
     * @param string $template_id
     * @param array $template_param
     * @return array
     * @throws Exception
     */
    public function sendBaidu($telephone, $template_id, $template_param)
    {
        return $this->client->apiPostRequest('/sms/baidu', [
            'telephone'      => $telephone,
            'template_id'    => $template_id,
            'template_param' => json_encode($template_param, JSON_UNESCAPED_UNICODE),
        ]);
    }
}