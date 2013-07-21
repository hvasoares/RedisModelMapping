<?php
namespace hvasoares\RedisModelMapping;
require_once 'SimpleRedisOperation.php';
use \Mockery as m;
class SimpleRedisOperationTest extends \PHPUnit_Framework_Testcase{
	public function testGivenAStrategyShouldOperate(){
		$strategy = m::mock('OperationStrategy');
		$strategy->shouldReceive('keyType')
			->andReturn('zset')
			->times(1);
		$strategy->shouldReceive('operate')
			->with('key','arg')
			->andReturn('val')
			->times(1);

		$instance = new SimpleRedisOperation($redis=m::mock('redism'),$strategy);

		$redis->shouldReceive('type')
			->with('key')
			->andReturn(4)	
			->times(1);
		$redis->shouldReceive('exists')
			->with('key')
			->andReturn(true)
			->times(1);

		$this->assertEquals(
			$instance->operate('key','arg'),
			'val'
		);
	}

	public function testIfKeyDoesntExistTheOperateNewKey(){
		$strategy = m::mock('OperationStrategy');
		$strategy->shouldReceive('keyType')
			->andReturn('zset')
			->times(1);
		$strategy->shouldReceive('operateNewKey')
			->with('key','arg')
			->andReturn('val')
			->times(1);

		$instance = new SimpleRedisOperation($redis=m::mock('redism'),$strategy);

		$redis->shouldReceive('exists')
			->with('key')
			->andReturn(false)
			->times(1);

		$this->assertEquals(
			$instance->operate('key','arg'),
			'val'
		);
	}	
}
?>
