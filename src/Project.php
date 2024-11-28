<?php

namespace RSHD\RSHDSDK;

use Exception;

abstract class Project
{
    /**
     * @var string
     */
    protected $projectName = '';

    /**
     * @param string $project_name
     * @throws Exception
     */
    public function __construct($project_name)
    {
        if (empty($project_name)) {
            throw new Exception('必须指定项目名称');
        }

        $this->projectName = $project_name;
    }
}