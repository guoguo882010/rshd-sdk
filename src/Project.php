<?php

namespace RSHDSDK;

use Exception;

abstract class Project
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @param array $project_config
     * @throws Exception
     */
    public function __construct($project_config)
    {
        if (empty($project_config)) {
            throw new Exception('项目配置不能为空');
        }

        $this->client = new Client($project_config);
    }

    /**
     * @param array $project_config
     * @return static
     * @throws Exception
     */
    public static function instance($project_config)
    {
        return new static($project_config);
    }
}