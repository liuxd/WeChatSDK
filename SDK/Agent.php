<?php

namespace weixin;

class Agent
{
    public function __construct($sModuleName, $sAppID, $sSecret)
    {
        $sRootPath = __DIR__ . DIRECTORY_SEPARATOR;
        require $sRootPath . 'Base.inc.php';

        $sModuleFilePath = $sRootPath . $sModuleName . '.module.php';

        if (!file_exists($sModuleFilePath)) {
            return false;
        }

        require $sModuleFilePath;

        $sClassName = "\\weixin\\$sModuleName";

        $this->{$sModuleName} = new $sClassName($sAppID, $sSecret);
    }
}

# end of this file