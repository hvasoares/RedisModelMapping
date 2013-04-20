<?php
$r = new redis();
$r->connect("localhost");

$zsetname = 'zset_'.time();

for($i=0; $i<5; $i++)
	$r->zadd($zsetname,1,'m_'.$i);

print_r($r->zcard($zsetname));
print_r($r->zrange($zsetname,4,4));
?>
