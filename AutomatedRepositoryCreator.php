<?php
namespace switch5\domain;
class AutomatedRepositoryCreator{
	public function __construct(&$registry){
		$this->r =&$registry;
	}
	public function createRepository($obj){
		$r = &$this->r;
		$array = explode("\\",get_class($obj));
		$modelName = lcfirst(array_pop($array));
		$r[$modelName.'Repository'] = $r['annotatedRepositoryBuilder']
			->buildFromObject($obj)
			->addListener($r['domainListener'])
			->get();
		
	}
}
?>
