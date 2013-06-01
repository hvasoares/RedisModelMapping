<?php
namespace switch5\domain\relationship;
require_once 'relationship/Builder.php';
use \Mockery as m;
class BuilderTest
	extends \PHPUnit_Framework_Testcase{
	public function testShouldPassArgumentsToTheListeners(){
		$urbf = m::mock('urbf');
		$uraf = m::mock('uraf');
		$r = array(
			'unidirectionalRelationshipBeforeSave' => $urbf,
			'unidirectionalRelationshipAfterFind' => $uraf

		);
		$inst = new Builder($r);

		$urbf->shouldReceive('setRepository')
			->with('aRepo')
			->once();
		$uraf->shouldReceive('setRepository')
			->with('aRepo')
			->once();
		$inst->setRepository('aRepo');

		$urbf->shouldReceive('setRelationshipAttribute')
			->with('attr')
			->once();
		$uraf->shouldReceive('setRelationshipAttribute')
			->with('attr')
			->once();
		$inst->setRelationshipAttribute('attr');


		$urbf->shouldReceive('setOneToOne')
			->with('attr')
			->once();
		$uraf->shouldReceive('setOneToOne')
			->with('attr')
			->once();
		$inst->setOneToOne('attr');


		$repoBuilder = m::mock('repoBuilder');
		$repoBuilder->shouldReceive('addListener')
			->with($uraf)
			->once();
		$repoBuilder->shouldReceive('addListener')
			->with($urbf)
			->once();

		$this->assertEquals(
			$inst->get($repoBuilder),
			$repoBuilder
		);

	}

}
?>
