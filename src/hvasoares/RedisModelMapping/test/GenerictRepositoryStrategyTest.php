<?php
namespace hvasoares\RedisModelMapping;
require_once 'GenericRepositoryStrategy.php';
require_once 'test/MockModelTest.php';
require_once 'test/RepositoryStrategyBehaviour.php';
class GenericRepositoryStrategyTest extends RepositoryStrategyBehaviour{
	public function getRepositoryStrategy(){
		$instance = new GenericRepositoryStrategy();

		$instance->attrs(
			'attr1','attr2'
		);

		$instance->setClass(
			get_class(new MockModelTest1())
		);

		return $instance;
	}

	public function getSampleModel(){
		return new MockModelTest1();	
	}

	public function getAttrs(){
		return array('attr1','attr2');	
	}
}
?>
