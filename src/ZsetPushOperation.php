<?php
namespace hvasoares\RedisModelMapping;
require_once 'validations.php';
use hvasoares\validations as v;
class ZsetPushOperation{
	public function __construct($redis){
		$this->r = $redis;
	}
	public function operate($key,$id){
		if($this->notCouldAddFirst($key,$id)){
			$r = $this->r;
			$last=$r->zcard($key)-1;
			$zrange =$r->zrange($key,$last,$last);
			$last_rank =$r->zscore(
				$key,
				$zrange[0]
			);
			$r->zadd($key,$last_rank+1,$id);
			return $last_rank + 1;
		}
		return 1;
	}
	private function notCouldAddFirst($key,$id){
		try{
			v\redisKeyExists($this->r,$key);
		}catch(v\ValidationException $ex){
			$this->r->zadd($key,1,$id);
			return false;
		}

		return true;
	}
}
?>
