<?php
namespace switch5\domain;
require_once 'validations.php';
use switch5\validations as v;
class RedisZsetHelper{
	public function __construct($redis){
		$this->r =v\notNull($redis);
	}
	public function setKey($val){
		$this->k = $val;
	}
	public function setRepository($val){
		$this->rp=$val;	
	}
	public function setOperations($val){
		$this->op = $val;
	}
	public function getByOrder($n){
		$this->valid();
		v\firstGreaterThanSecond($this->r->zcard($this->k),v\isInteger($n));
		$zrange = $this->r->zrange($this->k,$n,$n);
		if(sizeof($zrange)==0)
			return null;
		return $this->rp->find($zrange[0]);
	
	}
	private function valid(){
		v\notFalse(!is_null($this->k) && !is_null($this->r));
	}
	public function push($m){
		$this->op['push']->operate($this->k,$m->id());
	}

	public function remove($key){
		$this->zrem(v\mustBeAModel($key)->id());
	}

	public function exists($key){
		return $this->op['exists']->operate($this->k,v\mustBeAModel($key)->id());
	}
}
?>
