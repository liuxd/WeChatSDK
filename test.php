<?php

require __DIR__ . '/util.php';
require __DIR__ . '/SDK/Agent.php';

$agent = new Agent(['sModuleName' => 'User', 'sAppID' => $_GET['a'], 'sSecret' => $_GET['b']]);
$aUserInfo = $agent->User->getUserInfo($_GET['code']);
see($aUserInfo);

# end of this file
