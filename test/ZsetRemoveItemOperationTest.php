<?php
namespace switch5\domain;
require_once 'ZsetPushOperation.php';
use \Mockery as m;
class ZsetPushOperationTest extends \PHPUnit_Framework_Testcase{
	public function testPushASingleElementGivenItsOrder(){
		$redis = m::mock('reddism');

		$key='akey';
		$redis->shouldReceive('exists')
			->with($key)
			->andReturn(true);

		$inst = new ZsetPushOperation($redis);

		$redis->shouldReceive("zcard")
			->with($key)
			->andReturn(6)
			->times(1);
		$redis->shouldReceive('zrange')
			->with($key,5,5)
			->andReturn("a_id")
			->times(1);
		$redis->shouldReceive('zrank')
			->with($key,"a_id")
			->andReturn(100)
			->times(1);
		$redis->shouldReceive('zadd')
			->with($key,110,'aid')
			->times(1);


		$inst->operate($key,'aid');
	}

	public function testShouldAddAValueAtFirstIfKeyDoesntExists(){
		$redis = m::mock('reddism');
		$key='akey';
		$inst = new ZsetPushOperation($redis);

		$redis->shouldReceive('exists')
			->with($key)
			->andReturn(false);
		$redis->shouldReceive('zadd')
			->with($key,1,'aid')
			->times(1);

		$inst->operate($key,'aid');
	}
}
?>
