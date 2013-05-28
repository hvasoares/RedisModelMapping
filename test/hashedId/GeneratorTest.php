<?php
namespace switch5\domain\hashedId;
use \Mockery as m;
require_once 'hashedId/Generator.php';
require_once 'test/MockModelTest.php';
use switch5\domain;
class GeneratorTest extends \PHPUnit_Framework_Testcase{
	public function testBeforeSaveWithNewHash(){
		$this->beforeSave(true);
	}
	public function beforeSave($newModel,$attrs=array('attr1')){
		$expectedId = 'old_id';
		if($newModel)
			$expectedId = 'new_id';

		$redisM = m::mock("redism");
		$mapper = m::mock("mapper");
		$zsetPush= m::mock('zsetPush');
		$zsetExists= m::mock('zsetExists');
		$r = array(
			'Redis' => $redisM,
			'ZsetPush' => $zsetPush,
			'ZsetExists' => $zsetExists,
			'Mapper'=>$mapper,
			'sha1_salt' => 'salt'
		);
		$inst = new Generator($r);

		$m1 = new domain\MockModelTest1();
		$modelName = get_class($m1);
		call_user_func_array(
			array($inst,'setBaseProperty'),
			$attrs
		);
		$modelArray =array(
			'id' => 'a_id',
			'attr1' => 'some_value',
			'attr2' => 'other_value'
		);
		$mapper->shouldReceive('getArray')
			->with($m1)
			->andReturn($modelArray)
			->once();

		$hashedzset = $modelName."_hashed_generator";
		$result='';
		foreach($attrs as $attr)
			$result .= $modelArray[$attr];
		$hash = sha1($result.'salt');

		$existsResult = $expectedId;
		if($newModel)
			$existsResult = false;
	
		$zsetExists->shouldReceive('operate')
			->with($hashedzset,$hash)
			->andReturn($existsResult)
			->once();

		$redisM->shouldReceive('type')
			->with($hashedzset)
			->andReturn(4)
			->once();

		if(!$existsResult)
			$zsetPush->shouldReceive('operate')
				->with($hashedzset,$hash)
				->andReturn($expectedId)
				->once();

		$mapper->shouldReceive('arrayToModel')
			->with($m1,array(
				'id' => $expectedId,
				'attr1' => 'some_value',
				'attr2' => 'other_value'
			))
			->once();

		$this->assertEquals(
			$inst->beforeSave($m1),
			$m1
		);
		$this->assertEquals(
			$r['newest_id'],$expectedId
		);
	}
	public function testBeforeSaveWithPreviousSavedHash(){
		$this->beforeSave(false);
	}
	public function testBeforeSaveWithNewHashMultiAttr(){
		$this->beforeSave(true,array('attr1','attr2'));
	}
	public function testBeforeSaveWithPreviousSavedHashMultiAttr(){
		$this->beforeSave(false,array('attr1','attr2'));

	}


}
?>
