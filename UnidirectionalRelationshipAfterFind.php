<?php
namespace switch5\domain;
require_once 'ExtendedRepositoryListenerAdapter.php';
require_once 'validations.php';
use switch5\validations\ValidationException;
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
		try{
			$p->setValue($model,$ordered[0]);
		}catch(ValidationException $ex){
			//model doesn't has relationship
			return $model;
		}
		return $model;
	}	
}
?>
