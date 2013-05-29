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
		return $this;
	}
	public function setRelationshipAttribute($v){
		$this->uniBS->setRelationshipAttribute($v);
		$this->uniAF->setRelationshipAttribute($v);	
		return $this;
	}

	public function get($repoBuilder){
		$repoBuilder->addListener($this->uniAF);
		$repoBuilder->addListener($this->uniBS);
		return $repoBuilder;
	}
}
?>
