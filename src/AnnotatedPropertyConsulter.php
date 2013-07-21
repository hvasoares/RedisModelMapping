<?php
namespace hvasoares\RedisModelMapping;
use \ReflectionObject;
class AnnotatedPropertyConsulter{
	public function setAnnotationDriver($v){
		$this->d=$v;
	}

	public function getPersistentProperties($obj){
		$rf = new ReflectionObject($obj);
		$attrs = array();
		foreach($rf->getProperties() as $prop){
			if(!$this->isTransient($obj,$prop->getName()))
				$attrs[] = $prop->getName();
		}
		return $attrs;
	}

	private function isTransient($obj,$name){
		$annots = $this->d
			->getPropertyAnnotations($obj,$name);
		foreach($annots as $a){
			if($a instanceof PropertyAnnotation && $a->isTransient())
				return true;
		}

		return false;
	}
	public function getAllAnnotations($object){
		$allAnnots = array();
		$rf = new ReflectionObject($object);
		foreach($rf->getProperties() as $prop){
			$annots = $this->d->getPropertyAnnotations(
				$object,$prop->getName()
			);
			foreach($annots as $a){
				if($a instanceof PropertyAnnotation)
					$a->setPropertyName($prop->getName());
			}
			$allAnnots = array_merge(
				$allAnnots,$annots
			);
		}
		return $allAnnots;
	}
}?>
