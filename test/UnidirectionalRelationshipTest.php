<?php
namespace switch5\domain;
require_once 'UnidirectionalRelationship.php';
use \Mockery as m;
class UnidirectionalRelationshipTest
	extends \PHPUnit_Framework_Testcase{
	public function testShouldPassArgumentsToTheListeners(){
		$urbf = m::mock('urbf');
		$uraf = m::mock('uraf');
		$lc = m::mock('lc');
		$r = array(
			'unidirectionalRelationshipBeforeSave' => $urbf,
			'unidirectionalRelationshipAfterFind' => $uraf,

			'listenerChain' => $lc
		);
		$inst = new UnidirectionalRelationship($r);

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


		$lc->shouldReceive('add')
			->with($uraf)
			->once();
		$lc->shouldReceive('add')
			->with($urbf)
			->once();


		$this->assertEquals(
			$inst->get(),
			$lc
		);

	}

}
?>
