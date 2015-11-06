<?php
$code = $_GET['code'];
$key = 'key';

$mmc = memcache_connect();
memcache_set($mmc, $key, $code);
echo memcache_get($mmc, $key);