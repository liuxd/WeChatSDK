<?php

// require __DIR__ . '/util.php';
require __DIR__ . '/SDK/Agent.php';

$agent = new Agent(['sModuleName' => 'User', 'sAppID' => 'wx997a012f420c0ede', 'sSecret' => 'd4624c36b6795d1d99dcf0547af5443d']);
print_r($agent->User->getGlobalAccessToken());

# end of this file
