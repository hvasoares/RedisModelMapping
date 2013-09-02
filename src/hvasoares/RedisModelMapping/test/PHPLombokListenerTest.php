<?php
namespace hvasoares\RedisModelMapping;
use \Mockery as m;
require_once 'PHPLombokListener.php';
class PHPLombokListenerTest extends \PHPUnit_Framework_Testcase{
	public function testShouldGenerateObjectAfterSave(){
		$classGen = m::mock('childClassGenerator');
		$r = array(
			'childClassGenerator'=>$classGen
		);
		$inst = new PHPLombokListener($r);

		$classGen->shouldReceive('generate')
			->with('someObj')
			->andReturn('generatedObj')
			->once();

		$this->assertEquals(
			$inst->afterSave('someObj'),
			'generatedObj'
		);
	}

	public function testShouldGetTheOriginalObjectBeforeSave(){

		$generatedObj = m::mock('generatedObject');

		$generatedObj->shouldReceive('getAnnotatedObject')
			->andReturn('innerObject')
			->times(1);	

		$r = array(
			'childClassGenerator'=>'not important'
		);
		$inst = new PHPLombokListener($r);
		$this->assertEquals(
			$inst->beforeSave($generatedObj),
			"innerObject"
		);
	}

	public function testShouldGenerateObjectAfterFind(){
		$classGen = m::mock('childClassGenerator');
		$r = array(
			'childClassGenerator'=>$classGen
		);
		$inst = new PHPLombokListener($r);

		$classGen->shouldReceive('generate')
			->with('someObj')
			->andReturn('generatedObj')
			->once();

		$this->assertEquals(
			$inst->afterFind('someObj'),
			'generatedObj'
		);
	}

}
?>
