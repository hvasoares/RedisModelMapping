<?php
namespace switch5\domain;
require 'WeakEntityListener.php';
use \Mockery as m;
class WeakEntityListenerTest extends \PHPUnit_Framework_Testcase{
	public function testShouldThrowAnExceptionIfTheIdIsNull(){
		$model= m::mock('model');
		$model->shouldReceive('id')
			->andReturn(null)
			->once();

		$ins = new WeakEntityListener('childClass','fatherClass');

		try{
			$ins->beforeSave($model);
			$this->assertTrue(false);
		}catch(\Exception $ex){
			$this->assertEquals(
				$ex->getMessage(),
				'Objects of childClass must share id from fatherClass'
			);
		}


	}

	public function testIfNotNull(){
		$model= m::mock('model');
		$model->shouldReceive('id')
			->andReturn("nonNull")
			->once();

		$ins = new WeakEntityListener(
			'childClass',
			'fatherClass'
		);
		$this->assertEquals(
			$ins->beforeSave($model),
			$model
		);
	}
}
?>

