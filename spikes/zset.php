<?php
$r = new redis();
$r->connect("localhost");

$zsetname = 'zset_'.time();

for($i=0; $i<5; $i++)
	$r->zadd($zsetname,1+$i,'m_'.$i);

print_r($r->zcard($zsetname));
$zrange = $r->zrange($zsetname,4,4);
print_r($zrange);
print_r($r->zscore($zsetname,
	$zrange[0]
));
?>
