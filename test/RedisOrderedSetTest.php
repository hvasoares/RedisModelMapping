<?php
namespace switch5\domain;
require_once 'RedisOrderedSet.php';
require_once 'test/MockModelTest.php';
use \Mockery as m;
class RedisOrderedSetOfTest extends \PHPUnit_Framework_Testcase{
	public function setUp(){
		$sortedSetName ="switch5\domain\MockModelTest1";
		$sortedSetName.="[mockModelTest1Id]";
		$sortedSetName.= 'ToModel';
		$this->sortedSetName =$sortedSetName;
	}
	public function testShouldRetrieveFromRedis(){
		$toModel = new MockModelTest2();
		$helper = m::mock('zsethelper');
		$helper->shouldReceive('setKey')
			->with($this->sortedSetName)
			->times(1);

		$instance = new RedisOrderedSet($helper);
		$repo = m::mock("repo");
		$repo->shouldReceive('getClassName')
			->andReturn('ToModel')
			->times(1);
		$helper->shouldReceive('setRepository')
			->with($repo)
			->times(1);
		$helper->shouldReceive('push')
			->with($toModel)
			->times(1);
		$instance->setReferencedModel(
			new MockModelTest1()
		);
		$instance->setRepository($repo);

		$instance[]= $toModel;
	}

	public function testShouldGetAValueGivenItsOrder(){
		$helper = m::mock('zsethelper');
		$helper->shouldReceive('getByOrder')
			->with(0)
			->andReturn('model')
			->times(1);
		$helper->shouldReceive('setKey')
			->with($this->sortedSetName)
			->times(1);

		$instance = new RedisOrderedSet($helper);
		$repo = m::mock("repo");
		$repo->shouldReceive('getClassName')
			->andReturn('ToModel')
			->times(1);
		$helper->shouldReceive('setRepository')
			->with($repo)
			->times(1);
		$instance->setReferencedModel(
			new MockModelTest1()
		);
		$instance->setRepository($repo);
		$this->assertEquals($instance[0],'model');
	}

	public function testShouldUnsetGivenAModel(){
		$helper = m::mock('helper');
		$instance = new RedisOrderedSet($helper);
		$helper->shouldReceive('remove')
			->with('id_or_model')
			->times(1);
		unset($instance['id_or_model']);
	}

	public function testShouldCheckIfAOrderNumberOrModelExists(){
		$helper = m::mock('helper');
		$instance = new RedisOrderedSet($helper);
		$helper->shouldReceive('exists')
			->with('id_or_model')
			->andReturn(true)
			->times(1);
		$this->assertTrue(isset($instance['id_or_model']));
	}
}
?>
