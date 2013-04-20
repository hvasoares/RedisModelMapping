<?php
namespace switch5\domain;
require_once 'validations.php';
use switch5\validations as v;
class SimpleRedisOperation{
	public function __construct($redis,$strategy){
		$this->r =$redis;
		$this->s = $strategy;
	}
	public function operate($key,$arg){
		v\mustBeEqual(
			$this->s->keyType(),
			'zset'
		);

		if(!$this->r->exists($key))
			return $this->s->operateNewKey($key,$arg);
		if($this->r->type($key)==4)
			return $this->s->operate($key,$arg);
	}
}
?>
