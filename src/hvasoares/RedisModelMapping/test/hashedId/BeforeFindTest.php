<?php
namespace hvasoares\RedisModelMapping\hashedId;
require_once 'hashedId/BeforeSaveIdTunning.php';
use \Mockery as m;
class BeforeSaveIdTunningTest extends \PHPUnit_Framework_Testcase{
	public function testBeforeFind(){
		$mapper = m::mock('mapper');
		$zexists = m::mock('zSetExists');
		$model = 'aModel';
		$redis = m::mock("redismock");
		$r = array(
			'sha1_salt' => 'mmmmm',
			'Mapper' => $mapper,
			'attrs' => array('attr1','attr2'),
			'ZsetExists'=>$zexists,
			'zsetkey' => 'a_zset_key',
			'Redis' => $redis
		);

		$expectedHash = sha1('val1val2mmmmm');
		$inst = new BeforeSaveIdTunning($r);
	
		$mapper->shouldReceive("getArray")
			->with($model)
			->andReturn(array(
				'id'=>'not_important',
				'attr1' => 'val1',
				'attr2' => 'val2'
			))
			->once();
		$zexists->shouldReceive('operate')
			->with('a_zset_key',$expectedHash)
			->andReturn('some_value')
			->once();
		$redis->shouldReceive("zscore")
			->with('a_zset_key',$expectedHash)
			->andReturn('old_id');
		$mapper->shouldReceive('arrayToModel')
			->with($model,array(
				'id' =>'old_id',
				'attr1'=>'val1',
				'attr2'=>'val2'
			))
			->once();

		$this->assertEquals(
			$inst->beforeSave($model),
			$model
		);

	}
}
?>
