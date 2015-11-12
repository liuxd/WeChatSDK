<?php

class Agent
{
    /**
     * @param array $aParams ['sModuleName' => 'User', 'sAppID' => 'skjdf2342sdfhu', 'sSecret' => 'zxcbvwerusgdfgakheyu32734628']
     */
    public function __construct($aParams)
    {
        extract($aParams);

        $sRootPath = __DIR__ . DIRECTORY_SEPARATOR;
        require_once $sRootPath . 'Base.inc.php';

        $sModuleFilePath = $sRootPath . $sModuleName . '.module.php';

        if (!file_exists($sModuleFilePath)) {
            return false;
        }

        require_once $sModuleFilePath;

        $sClassName = "\\weixin\\$sModuleName";

        $this->{$sModuleName} = new $sClassName($sAppID, $sSecret);
    }
}

# end of this file