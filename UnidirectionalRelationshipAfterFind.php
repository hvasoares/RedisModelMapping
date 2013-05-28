<?php
namespace switch5\domain;
require_once 'ExtendedRepositoryListenerAdapter.php';
class UnidirectionalRelationshipAfterFind
	extends ExtendedRepositoryListenerAdapter{
	private $attr;
	public function __construct($registry){
		$this->r = $registry;
	}

	public function setRepository($v){
		$this->repo = $v;	
	}
	public function setRelationshipAttribute($v){
		$this->attr = $v;
	}
	public function afterFind($model){
		$ordered = $this->r['OrderedSet'];
		$ordered->setReferencedModel($model);
		$ordered->setRepository($this->repo);
		
		$rf = new \ReflectionObject($model);
		$p= $rf->getProperty($this->attr);
		$p->setAccessible(true);
		$p->setValue($model,$ordered[0]);
		return $model;
	}	
}
?>
