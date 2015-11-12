<?php

require __DIR__ . '/SDK/Agent.php';

$oRedis = new Redis;
$oRedis->connect('127.0.0.1', 6379);

$agent = new Agent(['sModuleName' => 'Menu', 'sAppID' => 'wx997a012f420c0ede', 'sSecret' => 'd4624c36b6795d1d99dcf0547af5443d', 'oRedis' => $oRedis]);

$aConfig = [
    "button" => [
        [
            "type" => "click", 
            "name" => "今日歌曲", 
            "key" => "V1001_TODAY_MUSIC"
        ], 
        [
            "name" => "菜单", 
            "sub_button" => [
                [
                    "type" => "view", 
                    "name" => "搜索", 
                    "url" => "http://www.soso.com/"
                ], 
            ]
        ]
    ]
];

print_r($agent->Menu->createConfig($aConfig));
// print_r($agent->Menu->getConfig());

# end of this file
