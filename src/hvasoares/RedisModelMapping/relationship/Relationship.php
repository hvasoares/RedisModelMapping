<?php
namespace hvasoares\RedisModelMapping\relationship;
require_once __DIR__.'/../PropertyAnnotation.php';
require_once __DIR__.'/../RepositoryBuilderAnnotation.php';
use \hvasoares\RedisModelMapping as d;
/** @Annotation */
class Relationship implements d\PropertyAnnotation,d\RepositoryBuilderAnnotation{
	public $repository;
	public $oneToMany = false;
	public function isTransient(){
		return true;
	}
	public function setPropertyName($v){
		$this->property = $v;
	}
	public function setRegistry($v){
		$this->r = $v;
	}

	public function getBuilder(){
		$builder = $this->r['relationshipBuilder'];
		$builder->setOneToOne(!$this->oneToMany);
		$builder->setRepository($this->repository);
		$builder->setRelationshipAttribute($this->property);
		return $builder;
	}
}
?>
