<?php

namespace RSHD\RSHDSDK;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

class SMS extends Project
{

    /**
     * @param $telephone
     * @param $message
     * @return array
     * @throws Exception|GuzzleException
     */
    public function sendESMS100($telephone, $message)
    {
        return \RSHD\RSHDSDK\Client::postRequest('/sms/sms100', [
            'telephone' => $telephone,
            'message'   => $message,
        ], $this->projectName);
    }

    /**
     * @param string $telephone
     * @param string $template_id
     * @param array $template_param
     * @return array
     * @throws GuzzleException
     */
    public function sendAliyun($telephone, $template_id, $template_param)
    {
        return \RSHD\RSHDSDK\Client::postRequest('/sms/aliyun', [
            'telephone'      => $telephone,
            'template_id'    => $template_id,
            'template_param' => json_encode($template_param, JSON_UNESCAPED_UNICODE),
        ], $this->projectName);
    }

    /**
     * @param string $telephone
     * @param string $template_id
     * @param array $template_param
     * @return array
     * @throws GuzzleException
     * @throws Exception
     */
    public function sendBaidu($telephone, $template_id, $template_param)
    {
        return \RSHD\RSHDSDK\Client::postRequest('/sms/baidu', [
            'telephone'      => $telephone,
            'template_id'    => $template_id,
            'template_param' => json_encode($template_param, JSON_UNESCAPED_UNICODE),
        ], $this->projectName);
    }
}