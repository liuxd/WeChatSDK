<?php

require __DIR__ . '/SDK/Agent.php';

$oRedis = new Redis;
$oRedis->connect('127.0.0.1', 6379);

$agent = new Agent(['sModuleName' => 'User', 'sAppID' => 'wx997a012f420c0ede', 'sSecret' => 'd4624c36b6795d1d99dcf0547af5443d', 'oRedis' => $oRedis]);

$agent = new Agent(['sModuleName' => 'Menu', 'sAppID' => 'wx997a012f420c0ede', 'sSecret' => 'd4624c36b6795d1d99dcf0547af5443d', 'oRedis' => $oRedis]);

print_r($agent->Menu->getConfig());

# end of this file
