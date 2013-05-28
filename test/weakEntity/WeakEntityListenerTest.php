<?php
namespace switch5\domain\weakEntity;
require 'weakEntity/WeakEntityListener.php';
use \Mockery as m;
class BeforeSaveListenerTest extends \PHPUnit_Framework_Testcase{
	public function testShouldThrowAnExceptionIfTheIdIsNull(){
		$model= m::mock('model');
		$model->shouldReceive('id')
			->andReturn(null)
			->once();

		$ins = new BeforeSaveListener('childClass','fatherClass');

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

		$ins = new BeforeSaveListener(
			'childClass',
			'fatherClass'
		);
		$this->assertEquals(
			$ins->beforeSave($model),
			$model
		);
		$this->assertTrue($ins->isSaving());

		$this->assertEquals(
			$ins->afterSave('model'),
			'model'
		);

		$this->assertFalse($ins->isSaving());

	}

}
?>

