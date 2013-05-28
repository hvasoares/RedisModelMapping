<?php
namespace switch5\domain;
use \Mockery as m;
abstract class RepositoryStrategyBehaviour extends \PHPUnit_Framework_Testcase{
	public function setUp(){
		$this->inst = $this->getRepositoryStrategy();
	}
	
	public function testShouldCreateTheAModelObject(){
		$this->assertEquals(
			get_class($this->inst->createNewModel()),
			get_class($this->getSampleModel())
		);
	}

	public function testSchemaShouldMapsModelAttrs(){
		$modelName = get_class($this->getSampleModel());
		$model = m::mock('model');
		$fn = $this->inst->getSchemaClosure();

		$model->shouldReceive('modelName')
			->with($modelName)
			->once();
		foreach($this->getAttrs() as $attr)
			$model->shouldReceive('attr')
				->with($attr)
				->once();
		$model->shouldReceive("setValidationClosure")
			->with($this->inst->getValidation())
			->once();
		$model->shouldReceive('incrKey')
			->with($modelName."_key")
			->once();

		$fn($model);
	}
	public abstract function getSampleModel();
	public abstract function getRepositoryStrategy();
	public abstract function getAttrs();
}

?>
