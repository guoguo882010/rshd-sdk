<?php

namespace RSHDSDK\UEditor;

use Exception;

/**
 * @since 2.6
 */
class UEditorProjectConfig
{
    protected $projectConfig = [];

    /**
     * @param array $projectConfig
     * @throws Exception
     */
    public function __construct($projectConfig)
    {
        if (empty($projectConfig)) {
            throw new Exception('项目配置文件不能为空');
        }

        $this->projectConfig = $projectConfig;
    }

    public function getProjectConfig()
    {
        return $this->projectConfig;
    }
}