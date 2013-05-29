<?php
namespace switch5\domain\hashedId;
require_once 'hashedId/RepositoryStrategy.php';
use \Mockery as m;
class RepositoryStrategyTest extends \PHPUnit_Framework_Testcase{
	public function testShouldBeAwareAboutTheModelKey(){
		$r = array();	
		$asserter = $this;
		$innerStrategy = m::mock('repo');
		$schemaL = m::mock("schemaL");
		$model = 'amodel';

		$inst = new RepositoryStrategy($innerStrategy,$r);
		$inst->setSchemaClosureListener($schemaL);

		$schemaL->shouldReceive('setModel')
			->with($model)
			->once();
		$schemaL->shouldReceive('incrKey')
			->with('a_key')
			->once();
		$schemaL->shouldReceive('getIncrKey')
			->andReturn('a_key')
			->once();
		$closure = function($model) use($asserter,$schemaL){
			$model->incrKey('a_key');
			$asserter->assertEquals($model,$schemaL);
		};
		$innerStrategy->shouldReceive('getSchemaClosure')
			->andReturn($closure)
			->once();
		$fn=$inst->getSchemaClosure();
	
		$fn($model);
		$this->assertEquals($r['zsetkey'],'a_key_hashed_generator');
		$this->assertEquals($r['modelKey'],'a_key');

	}
}
?>
