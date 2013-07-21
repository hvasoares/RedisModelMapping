<?php
namespace hvasoares\RedisModelMapping;
require_once 'OrderedSet.php';
require_once 'validations.php';
use hvasoares\validations as v;
class RedisOrderedSet implements OrderedSet{
	public function __construct($zSetHelper){
		$this->h = v\notNull($zSetHelper);
	}
	public function setReferencedModel($model){
		$this->model = 	$model;
	}
	public function setRepository($val){
		$this->toModelClass = $val->getClassName();
		$this->h->setKey($this->keyName());
		$this->h->setRepository($val);
	}
	public function offsetGet($key){
		return $this->h->getByOrder(v\isInteger($key));
	}
	public function offsetSet($key,$value){
		v\notFalse(is_null($key));
		$this->h->push($value);
	}
	private function keyName(){
		return 	get_class($this->model).
			"[".$this->model->id()."]".
			$this->toModelClass;
	}
	public function offsetUnset($key){
		$this->h->remove($key);
	}
	public function offsetExists($key){
		return $this->h->exists($key);
	}
}
?>
