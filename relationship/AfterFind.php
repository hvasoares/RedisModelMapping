<?php
namespace switch5\domain\relationship;
require_once __DIR__.'/../ExtendedRepositoryListenerAdapter.php';
require_once __DIR__.'/../validations.php';
use switch5\validations\ValidationException;
class AfterFind
	extends \switch5\domain\ExtendedRepositoryListenerAdapter{
	private $attr;
	public function __construct($registry){
		$this->r = $registry;
		$this->card1 = true;
	}

	public function setOneToOne($v){
		$this->card1=$v;
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
		$ordered->setRepository($this->r[$this->repo]);
		
		$rf = new \ReflectionObject($model);
		$p= $rf->getProperty($this->attr);
		$p->setAccessible(true);
		try{
			$p->setValue($model,$this->card1? $ordered[0] : $ordered);
		}catch(ValidationException $ex){
			//model doesn't has relationship
			return $model;
		}
		return $model;
	}	
}
?>
