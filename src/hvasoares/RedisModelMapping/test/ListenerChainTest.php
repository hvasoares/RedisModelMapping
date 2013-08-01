<?php
namespace hvasoares\RedisModelMapping;
require_once 'ListenerChain.php';
use \Mockery as m;
class ListenerChainTest extends \PHPUnit_Framework_Testcase{
	public function setUp(){
		$this->ins = new ListenerChain();
		$this->l1 = m::mock('listener1');
		$this->l2 = m::mock('listener2');

		$this->ins->add($this->l1);
		$this->ins->add($this->l2);
	}
	public function testBeforeFindChain(){
		$this->l1->shouldReceive('beforeFind')
			->with('anId')
			->once();
		$this->l2->shouldReceive('beforeFind')
			->with('anId')
			->once();
		$this->ins->beforeFind('anId');
	}
	public function testAfterFind(){
		$this->modelTransformingBehaviour("afterFind");
		$this->assertEquals(
			$this->ins->afterFind('aModel'),
			'aModelModified2'
		);

	}
	public function testBeforeSave(){
		$this->modelTransformingBehaviour('beforeSave');
		$this->assertEquals(
			$this->ins->beforeSave('aModel'),
			'aModelModified2'
		);
	}
	public function testAfterSave(){
		$this->modelTransformingBehaviour('afterSave');
		$this->assertEquals(
			$this->ins->afterSave('aModel'),
			'aModelModified2'
		);
	}
	public function testDeleteListener(){
		$this->l1->shouldReceive('deleteListener')
			->with('aModel')
			->once();
		$this->l2->shouldReceive('deleteListener')
			->with('aModel')
			->once();
		$this->ins->deleteListener('aModel');
	
	}

	private function modelTransformingBehaviour($methodName){
		$this->l1->shouldReceive($methodName)
			->with('aModel')
			->andReturn('aModelModified')
			->once();
		$this->l2->shouldReceive($methodName)
			->with('aModelModified')
			->andReturn('aModelModified2')
			->once();
	
	}
}
?>
