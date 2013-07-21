<?php
namespace hvasoares\RedisModelMapping;
require_once "AutomatedRepositoryCreator.php";
require_once "test/MockModelTest.php";
use \Mockery as m;
class AutomatedRepositoryCreatorTest extends \PHPUnit_Framework_Testcase{
	public function testShouldCreateTheRepositoryInRegistry(){
		$r = array(
			'annotatedRepositoryBuilder' => $builder = m::mock('builder'),
			'RedisModelMappingListener' => 'aDomain'
		);
			$inst = new AutomatedRepositoryCreator($r);
		$object = new MockModelTest1();
	
		$builder->shouldReceive('buildFromObject')
			->with($object)
			->andReturn($repoBuilder = m::mock('repoBuilder'))
			->once();

		$repoBuilder->shouldReceive('addListener')
			->with($r['RedisModelMappingListener'])
			->andReturn($repoBuilder)
			->once();

		$repoBuilder->shouldReceive('get')
			->andReturn('newRepo');
		$inst->createRepository($object);

		$this->assertEquals(
			$r['mockModelTest1Repository'],
			'newRepo'
		);
	}	
}
?>
