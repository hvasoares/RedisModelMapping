<?php
$key = 'testing'.time();
$r = new redis();
$r->connect('127.0.0.1');
$r->zadd($key,0,'a_member');
echo $r->type($key);
?>
