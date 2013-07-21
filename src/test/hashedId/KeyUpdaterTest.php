<?php
namespace hvasoares\RedisModelMapping\hashedId;
use \Mockery as m;
require 'hashedId/KeyUpdater.php';
class KeyUpdaterTest extends \PHPUnit_Framework_Testcase{
	public function testShouldUpdateTheModelIncrKey(){
		$redis = m::mock('redism');
		$new_id = 4;
		$r = array(
			'Redis' => $redis,
			'modelKey' => 'a_key',
			'newest_id'=> $new_id
		);

		$redis->shouldReceive('incr')
			->with('a_key')
			->andReturn(1,2,3,4)
			->times(4);
		
		$inst = new KeyUpdater($r);
		$this->assertEquals(
			$inst->beforeSave('model'),
			'model'
		);
		$this->assertFalse(isset($r['newest_id']));
	}	

}
