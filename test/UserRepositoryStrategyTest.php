<?php
namespace switch5\domain;
require 'UserRepositoryStrategy.php';
use \Mockery as m;
class UserRepositoryStrategyTest extends \PHPUnit_Framework_Testcase{
	public function setUp(){
		$this->inst = new UserRepositoryStrategy();
	}
	
	public function testShouldCreateTheAUserObject(){
		$this->assertEquals(
			get_class($this->inst->createNewModel()),
			get_class(new User())
		);
	}

	public function testSchemaShouldMapsUserAttrs(){
		$model = m::mock('model');
		$fn = $this->inst->getSchemaClosure();

		$model->shouldReceive('modelName')
			->with('switch5\domain\User')
			->once();

		$model->shouldReceive('attr')
			->with('created_time')
			->once();
		$model->shouldReceive('attr')
			->with("modified_time")
			->once();
		$model->shouldReceive("setValidationClosure")
			->with($this->inst->getValidation())
			->once();
		$model->shouldReceive('incrKey')
			->with('switch5\domain\User_key')
			->once();

		$fn($model);
	}
}
?>
