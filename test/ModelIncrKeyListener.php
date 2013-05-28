<?php
namespace switch5\domain;
require_once 'ModelIncrKeyListener.php';
use \Mockery as m;
class ModelIncrKeyListenerTest extends \PHPUnit_Framework_Testcase{
	public function testShouldStoreTheIncrKey(){
		$innerM = m::mock("model");
		$innerM->shouldReceive('incrKey')
			->with('some_key')
			->once();

		$inst = new ModelIncrKeyListener();
		$inst->setModel($innerM);

		$inst->incrKey('some_key');

		$this->assertEquals(
			$inst->getIncrKey(),
			'some_key'
		);
	}
}
