<?php
namespace hvasoares\RedisModelMapping;
require_once 'validations.php';
use hvasoares\validations as v;
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
		$this->op['push']->operate(
			$this->k,$m->id()
		);
	}

	public function remove($key){
		$model = $key;
		
		if(is_numeric($key))
			$model=$this->getByOrder($key);
		if($model)
			$this->r->zrem(
				$this->k,
				v\mustBeAModel($model)->id()
			);
	}

	public function exists($key){
		return $this->op['exists']->operate($this->k,v\mustBeAModel($key)->id());
	}
}
?>
