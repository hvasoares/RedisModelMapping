<?
$r = new redis();
$rand = rand();
$store = array();
$r->connect("127.0.0.1");
function haversine($lt1,$lg1,$lt2,$lg2){
	$earthRadius=6371;
	$lt1r =deg2rad($lt1);
	$lg1r = deg2rad($lg1);
	$lt2r= deg2rad($lt2);
	$lg2r = deg2rad($lg2);

	$latD = $lt2r-$lt1r;
	$logD = $lg2r-$lg1r;
	
	$f1 = pow(sin($latD/2),2);
	$f2 = pow(sin($logD/2),2);
	$cossenos = cos($lt1r)*cos($lt2r);
	$angle = 2 * asin(sqrt($f1+$cossenos*$f2));
	return $angle*$earthRadius;

}
function createVal($val){
	$rand = rand()+1;
	$value = pow(-1,$rand%3)
		*$rand%$val+
		(0.1+1/(1+$rand%1000));
	return $value;
}


function getClose($r,$key,$member,$mod){
	$middle = $r->zrank($key,$member);
	$zrange = $r->zrange($key,$middle-100,$middle+100,true);
	$aux = $member;
	foreach($zrange as $member=>$score){
		if($member!=$aux)
			$r->zadd("$mod.store.$key",$score,$member);
	}
	return "$mod.store.$key";
}

function getNext($r,$keyLat,$keyLog,$member){
	$nearLat = getClose($r,$keyLat,$member,90);
	$nearLog = getClose($r,$keyLog,$member,180);

	$interMembers ="inter$member";
	$r->zInterStore($interMembers,array($nearLat,$nearLog));
	$closers="closers$member";	
	$memberLat = 	$r->zScore($keyLat,$member);
	$memberLog =  	$r->zScore($keyLog,$member);
	echo "$memberLat,$memberLog\n";
	for($i=0; $i<$r->zCard($interMembers);$i++){
		$zrange = $r->zRange($interMembers,$i,$i);
		$other = $zrange[0];
		$otherLat = 	$r->zScore($nearLat,$other);
		$otherLog =$r->zScore($nearLog,$other);
		
		$haversine=haversine(
			$memberLat,
			$memberLog,
			$otherLat,
			$otherLog
		);

		echo "$member,$other,$otherLat,$otherLog,$haversine\n";
 
		$r->zAdd($closers,$haversine,$other);
	}
	$zrangeResult = $r->zRange($closers,0,0);
	$r->delete($closers);
	$r->delete($nearLog);
	$r->delete($nearLat);
	$result = $zrangeResult[0];
	echo "choosed $result\n";
	return $result;
}

$i=1000;
$key="zset$i";
$keyx="x$key";
$keyy="y$key";

$r->delete($keyx);
$r->delete($keyy);

for($j=0;$j<$i;$j++){
	$r->zAdd($keyx,createVal(180),$j);
	$r->zAdd($keyy,createVal(90),$j);
}

$before = time();
$valuelat = createVal(180);
$valuelog = createval(90);
$member = rand()%$i;

$closer = getNext($r,$keyx,$keyy,$member);

$allzsets = array(
	$keyx,
	$keyy,
);
foreach($allzsets as $zset)
	$r->delete($zset);

$total = time()-$before;
?>
