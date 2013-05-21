<?php
namespace switch5\domain;
use \Mockery as m;
require 'ExtendedRepository.php';
class ExtendedRepositoryTest extends \PHPUnit_Framework_Testcase{
	public function testShouldMergeRawRepository(){
		$rawRepo = m::mock('rawRepo');
		$rawRepoStrategy = m::mock('rawRepoStrategy');
		$listener = m::mock('listener');

		$rawRepo->shouldReceive('setStrategy')
			->with($rawRepoStrategy)
			->once();

		$ins = new ExtendedRepository(
			$rawRepo,
			$rawRepoStrategy,
			$listener
		);

		$rawRepo->shouldReceive('find')
			->with('anId')
			->andReturn('model')
			->once();
		$listener->shouldReceive('beforeFind')
			->with('anId')
			->once();
		$listener->shouldReceive('afterFind')
			->with('model')
			->andReturn('modelAfterFind')
			->once();
		$this->assertEquals(
			$ins->find('anId'),
			'modelAfterFind'
		);

		$listener->shouldReceive('beforeSave')
			->with('amodel')
			->andReturn('amodelBeforeSave');
		$rawRepo->shouldReceive('save')
			->with('amodelBeforeSave')
			->once();
		$listener->shouldReceive('afterSave')
			->with('amodel')
			->once();
		$ins->save('amodel');

		$rawRepoStrategy->shouldReceive('createNewModel')
			->andReturn('brandNewModel')
			->once();
		$this->assertEquals(
			$ins->createNewModel(),
			'brandNewModel'
		);	

		$listener->shouldReceive('deleteListener')
			->with('amodel')
			->once();
		$ins->delete('amodel');
	}
}
