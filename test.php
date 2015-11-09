#!/usr/bin/env php
<?php

require __DIR__ . '/util.php';
require __DIR__ . '/SDK/Agent.php';

$agent = new \weixin\Agent('User', 'wx1061e4e55dd6de25', '9dbfb0f945333b1c141cbc215aa734c3');
$agent->User->getUserInfo($_GET['code']);

# end of this file
