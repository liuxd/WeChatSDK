<?php

require __DIR__ . '/util.php';
require __DIR__ . '/SDK/Agent.php';

$agent = new \weixin\Agent('User', $_GET['a'], $_GET['b']);
$aUserInfo = $agent->User->getUserInfo($_GET['code']);
see($aUserInfo);

# end of this file
