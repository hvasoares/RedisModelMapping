<?php
namespace switch5\domain;
class ZsetExistsOperationStrategy{
	public function __construct($redis){
		$this->r=$redis;
	}
	public function operateNewKey($key,$arg){
		return false;
	}
	public function operate($key,$arg){
		$r= $this->r->zscore($key,$arg)||false;
		return $r;
	}
}
?>
