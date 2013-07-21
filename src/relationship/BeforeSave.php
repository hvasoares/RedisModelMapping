<?php
namespace hvasoares\RedisModelMapping\relationship;
require_once __DIR__.'/../ExtendedRepositoryListenerAdapter.php';
class BeforeSave 
	extends \hvasoares\RedisModelMapping\ExtendedRepositoryListenerAdapter {
	private $repository;
	private $attr;
	public function __construct($r){
		$this->r=$r;
		$this->card1 = true;
	}
	public function setRepository($v){
		$this->repository=$v;
	}
	public function setRelationshipAttribute($v){
		$this->attr = $v;
	}
	public function setOneToOne($v){
		$this->card1 = $v;
	}
	public function beforeSave($model){

		if($this->card1){
			$c=0;
			$m=$this->r['Mapper'];
			$o=$this->r['OrderedSet'];
			$repo = $this->r[$this->repository];
			$o->setReferencedModel($model);
			$o->setRepository($repo);

			$attrs = $m->getArray($model);
			$rm = $attrs[$this->attr];
			if(!$rm)
				return $model;
			$om =$repo->find($rm->id());
			if($om){
				if($o[0]!=null
					&& $o[0]->id()!=$om->id()){
					unset($o[0]);
				}
				$o[]=$om;
			}
		}
		return $model;
	}
}
?>
