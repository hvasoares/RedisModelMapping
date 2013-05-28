<?php
namespace switch5\domain;
require_once 'ExtendedRepositoryListenerAdapter.php';
class UnidirectionalRelationshipBeforeSave 
	extends ExtendedRepositoryListenerAdapter {
	private $repository;
	private $attr;
	public function __construct($r){
		$this->r=$r;
	}
	public function setRepository($v){
		$this->repository=$v;
	}
	public function setRelationshipAttribute($v){
		$this->attr = $v;
	}
	public function setCardinality($v){
		if($v!=1)
			throw new Exception("Not implemented yet forcardinality more than 1");
	}
	public function beforeSave($model){
		$m=$this->r['mapper'];
		$o=$this->r['OrderedSet'];
		$o->setRepository($this->repository);
		$o->setReferencedModel($model);
		$attrs = $m->getArray($model);
		$rm = $attrs[$this->attr];
		$om =$this->repository->find($rm->id());
		if($om){
			unset($o[0]);
			$o[]=$om;
			return $model;
		}
	}
}
?>
