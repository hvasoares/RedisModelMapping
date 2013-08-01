<?php
namespace hvasoares\RedisModelMapping;
require_once 'AnnotatedRepositoryBuilder.php';
require_once 'AnnotationDriver.php';
require_once 'PropertyAnnotation.php';
require_once 'RepositoryBuilderAnnotation.php';
require_once 'test/MockModelTest.php';
use \Mockery as m;
class AnnotatedRepositoryBuilderTest 
	extends \PHPUnit_Framework_Testcase{
	
	public function testShouldBuildARepositoryGivenAClass(){
		$object = new MockModelTest1();	
		$r=array(
			'genericRepositoryStrategy' => $gRepos = m::mock('strategy'),
			'repositoryBuilder' => $rBuilder = m::mock('rbuilder'),
			"annotationDriver" => $annoDriver = m::mock(
				'\stdClass,'.
				'hvasoares\RedisModelMapping\AnnotationDriver'
			),
			'annotatedPropertyConsulter' => $pconsul=m::mock('consulter')
		);
		$inst = new AnnotatedRepositoryBuilder($r);	

		$gRepos->shouldReceive('setClass')
			->with(get_class($object))
			->once();

		$pconsul->shouldReceive(
			'getPersistentProperties'
		)
		->with($object)
		->andReturn(array("attr2"))
		->once();
		$gRepos->shouldReceive('attrs')
			->with('attr2')
			->once();

		$pconsul->shouldReceive('getAllAnnotations')
			->with($object)
			->andReturn(array(
				$yesT = m::mock('stdClass,'.
				'hvasoares\RedisModelMapping\RepositoryBuilderAnnotation'
			),
				$no = m::mock('neverCalled')

			));

		$annoDriver->shouldReceive(
			'getClassAnnotationsFromObject'
		)->with($object)
		->andReturn(array(
			m::mock('noRepobuilder'),
			$classRepoBuilder = m::mock(
				'\stdClass,'.
				'hvasoares\RedisModelMapping\RepositoryBuilderAnnotation'
			)
		))
		->once();


		$rBuilder->shouldReceive('strategy')
			->with($gRepos)
			->once();	

		$classRepoBuilder->shouldReceive('getBuilder')
			->andReturn(
				$classBuilder=m::mock('cbuilder')
			)->once();
		$yesT->shouldReceive('getBuilder')
			->andReturn(
				$yesBuilder=m::mock('ybuilder')
			)->once();
		$yesT->shouldReceive('setRegistry')
			->with($r)
			->once();
		$classRepoBuilder->shouldReceive('setRegistry')
			->with($r)
			->once();

		$yesBuilder->shouldReceive('get')
			->with($rBuilder)
			->once();
		$classBuilder->shouldReceive('get')
			->with($rBuilder)
			->once();
		$this->assertEquals(
			$rBuilder,
			$inst->buildFromObject($object)
		);
	}
}
?>
