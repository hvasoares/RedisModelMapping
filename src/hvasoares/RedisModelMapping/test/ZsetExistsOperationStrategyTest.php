<?php
namespace hvasoares\RedisModelMapping;
require_once 'ZsetExistsOperationStrategy.php';
use \Mockery as m;
class ZsetExistsOperationStrategyTest extends \PHPUnit_Framework_Testcase{
	public function testOperateNewAlwaysReturnFalse(){
		$inst = new ZsetExistsOperationStrategy(m::mock('redism'));
		$this->assertFalse(
			$inst->operateNewKey(null,null)
		);
	}

	public function testOperate(){
		$r = m::mock('redism');
		$inst = new ZsetExistsOperationStrategy($r);
		$r->shouldReceive('zscore')
			->with('key','id')
			->andReturn(true)
			->times(1);
		$this->assertTrue(
			$inst->operate('key','id')
		);

	}
}
?>
