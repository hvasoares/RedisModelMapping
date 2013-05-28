<?php
namespace switch5\domain;
class UnidirectionalRelationship{
	public function __construct($r){
		$this->r=$r;
		$this->uniBS=$r[
			'unidirectionalRelationshipBeforeSave'
		];
		$this->uniAF=$r[
			'unidirectionalRelationshipAfterFind'
		];

	}
	public function setRepository($v){
		$this->uniBS->setRepository($v);
		$this->uniAF->setRepository($v);		
	}
	public function setRelationshipAttribute($v){
		$this->uniBS->setRelationshipAttribute($v);
		$this->uniAF->setRelationshipAttribute($v);	
	}

	public function get(){
		$lc = $this->r['listenerChain'];	
		$lc->add($this->uniAF);
		$lc->add($this->uniBS);
		return $lc;
	}
}
?>
