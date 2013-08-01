<?php
namespace hvasoares\RedisModelMapping\weakEntity;
require_once 'weakEntity/WeakEntityRepositoryStrategy.php';
use \Mockery as m;
class RepositoryStrategyTest extends \PHPUnit_Framework_Testcase{
	public function testShouldDoNotValidationsIfIsNewOne(){
		$weakEntityListener = m::mock('listener');
		$innerRepo = m::mock('repo');
		$inst = new RepositoryStrategy(
				$innerRepo,
			$weakEntityListener
		);		
		$innerRepo->shouldReceive('getValidation')
			->andReturn('innerVal')
			->once();

		$weakEntityListener->shouldReceive('isSaving')
			->andReturn(true)
			->once();

		$fn = $inst->getValidation();

		$this->assertTrue($fn(array(
			'id' => 'anId',
			'attr' => null
		)));

	}
	public function testifNotSavingThenGetTheInnerValidation(){
		$weakEntityListener = m::mock('listener');
		$innerRepo = m::mock('repo');
		$inst = new RepositoryStrategy(
			$innerRepo,
			$weakEntityListener
		);		

		$weakEntityListener->shouldReceive('isSaving')
			->andReturn(false)
			->once();
		$asserter = $this;
		$innerVal = function($raw) use($asserter){
			$asserter->assertEquals($raw,'avalue');
		};
		$innerRepo->shouldReceive('getValidation')
			->andReturn($innerVal)
			->once();

		$fn =$inst->getValidation();
		$fn('avalue');
	}

	public function testSchemaClosureShouldOverrideValidation()
	{
		$weakEntityListener = m::mock('listener');
		$innerRepo = m::mock('repo');
		$inst = new RepositoryStrategy(
			$innerRepo,
			$weakEntityListener
		);
		$innerRepo->shouldReceive('getValidation')
			->andReturn('innerVal')
			->atLeast(1);

		$asserter = $this;
		$model = m::mock('model');
		$model->shouldReceive('setValidationClosure')
			->with($inst->getValidation())
			->once();
		$innerSchema = function($omodel)
			use($model,$asserter){
			$asserter->assertEquals($omodel,$model);
		};
		
		$innerRepo->shouldReceive('getSchemaClosure')
			->andReturn($innerSchema)
			->once();

		$fn = $inst->getSchemaClosure();	
	
		$fn($model);
	}
}
?>
