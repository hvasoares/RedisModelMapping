<?php
namespace hvasoares\RedisModelMapping;
use ReflectionObject;
class AnnotatedRepositoryBuilder{
	public function __construct($r){
		$this->r = $r;
		$this->builders=array();
	}
	public function buildFromObject($obj){
		$genRepoSt = $this->r['genericRepositoryStrategy'];		   
		$genRepoSt->setClass(get_class($obj));
		$annotDriver = $this->r['annotationDriver'];
		$annotProper = $this->r['annotatedPropertyConsulter'];
		$repoBuilder = $this->r['repositoryBuilder'];
		$classAnnots = $annotDriver
			->getClassAnnotationsFromObject($obj);
		call_user_func_array(
			array($genRepoSt,'attrs'),
			$annotProper->getPersistentProperties($obj)
		);
		
		$repoBuilder->strategy($genRepoSt);
		$allAnnots = array_merge($classAnnots,
			$annotProper->getAllAnnotations($obj)
		);
		foreach($allAnnots as $a){
			if($a instanceof RepositoryBuilderAnnotation){
				$a->setRegistry($this->r);
				$a->getBuilder()
					->get($repoBuilder);
			}
			
		}
		return $repoBuilder;
	}
}
?>
