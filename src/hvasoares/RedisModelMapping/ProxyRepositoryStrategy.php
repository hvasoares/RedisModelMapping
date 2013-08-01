<?php
namespace hvasoares\RedisModelMapping;
require_once 'RepositoryStrategy.php';
abstract class ProxyRepositoryStrategy implements RepositoryStrategy{
	protected $innerStrategy;
	public function __construct($innerStrategy){
		$this->innerStrategy =$innerStrategy;
	}

	public function createNewModel(){
		return $this->innerStrategy->createNewModel();
	}

	public function getSchemaClosure(){
		return $this->innerStrategy->getSchemaClosure();
	}

	public function getValidation(){

		return $this->innerStrategy->getValidation();
	}
	public function setStrategy($v){
		$this->innerStrategy=$v;
	}
}
?>
