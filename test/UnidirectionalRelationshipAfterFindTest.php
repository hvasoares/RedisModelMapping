<?php
namespace switch5\domain;
require 'UnidirectionalRelationshipAfterFind.php';
require_once 'test/MockModelTest.php';
use \Mockery as m;
class UnidirectionalRelationshipAfterFindTest
	extends \PHPUnit_Framework_Testcase{
	public function testShouldGetTheFirstContentOfSetAndSetIntoModel(){
		$orderedSet = m::mock('stdClass,\ArrayAccess');
		$repo = 'aRepo';
		$m1 = new MockModelTest1();
		$m2 = new MockModelTest2();
		$inst = new UnidirectionalRelationshipAfterFind(
			array('OrderedSet'=>$orderedSet)
		);

		$orderedSet->shouldReceive('offsetGet')
			->with(0)
			->andReturn($m2)
			->once();
		$orderedSet->shouldReceive('setReferencedModel')
			->with($m1)
			->once();
		$orderedSet->shouldReceive('setRepository')
			->with($repo)
			->once();
		$inst->setRelationshipAttribute('attr1');
		$inst->setRepository($repo);
		$inst->afterFind($m1);

		$this->assertEquals($m1->attr1(),$m2);

	}
}
