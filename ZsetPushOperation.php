<?php
namespace switch5\domain;
require_once 'validations.php';
use switch5\validations as v;
class ZsetPushOperation{
	public function __construct($redis){
		$this->r = $redis;
	}
	public function operate($key,$id){
		if($this->notCouldAddFirst($key,$id)){
			$r = $this->r;
			$last=$r->zcard($key)-1;
			$last_rank =$r->zrank(
				$key,
				$r->zrange($key,$last,$last)
			);
			$r->zadd($key,$last_rank+10,$id);
			return $last_rank + 10;
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
