<?php

require __DIR__ . '/util.php';
require __DIR__ . '/SDK/Agent.php';

$agent = new \weixin\Agent('User', 'wx1061e4e55dd6de25', '9dbfb0f945333b1c141cbc215aa734c3');
$aUserInfo = $agent->User->getUserInfo($_GET['code']);
see($aUserInfo);

# end of this file
