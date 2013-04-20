<?php
namespace switch5\domain;
use \Mockery as m;
require_once 'RedisZsetHelper.php';
require_once 'test/MockModelTest.php';
class RedisZsetHelperTest extends \PHPUnit_Framework_Testcase{
	public function setUp(){
		$redis = m::mock('redism');
		$instance = new RedisZsetHelper($redis);

		$instance->setRepository($repo = m::mock('repo'));
		$instance->setKey("akey");
		$this->instance =$instance;
		$this->r = $redis;
		$this->rp =$repo;
	}
	public function testGetByOrder(){
		$this->r->shouldReceive('zcard')
			->andReturn(6)
			->times(1);

		$this->r->shouldReceive('zrange')
			->with('akey',0,0)
			->andReturn('aid')
			->times(1);
		$this->rp->shouldReceive('find')
			->andReturn('a_model')
			->times(1);
		$this->assertEquals(
			$this->instance->getByOrder(0),
			'a_model'
		);
	}

	public function testshouldPushAnObjectToLastPosition(){
		$this->instance->setOperations(array(
			'push' => $push = m::mock('push')
		));
		$push->shouldReceive('operate')
			->with('akey','mockModelTest1Id')
			->times(1);
		$this->instance->push(new MockModelTest1());
	}

} 
?>
