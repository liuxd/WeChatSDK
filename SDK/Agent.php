<?php

class Agent
{
    /**
     * @param array $aParams ['sModuleName' => 'User', 'sAppID' => 'skjdf2342sdfhu', 'sSecret' => 'zxcbvwerusgdfgakheyu32734628', 'oRedis' => $oRedis]
     * @return false
     */
    public function __construct($aParams)
    {
        if (!isset($aParams['sModuleName']) || !isset($aParams['sAppID']) || !isset($aParams['sSecret'])) {
            return false;
        }

        extract($aParams);

        $sRootPath = __DIR__ . DIRECTORY_SEPARATOR;
        require_once $sRootPath . 'Base.inc.php';

        $sModuleFilePath = $sRootPath . $sModuleName . '.module.php';

        if (!file_exists($sModuleFilePath)) {
            return false;
        }

        require_once $sModuleFilePath;
        $sClassName = "\\weixin\\$sModuleName";
        $this->{$sModuleName} = new $sClassName($sAppID, $sSecret, $aParams['oRedis']);

        return true;
    }
}

# end of this file