<?php
namespace hvasoares\RedisModelMapping\relationship;
require 'relationship/AfterFind.php';
require_once 'test/MockModelTest.php';
use \Mockery as m;
use \hvasoares\RedisModelMapping;
class AfterFindTest
	extends \PHPUnit_Framework_Testcase{
	public function testShouldGetTheFirstContentOfSetAndSetIntoModel(){
		$orderedSet = m::mock('stdClass,\ArrayAccess');
		$repo = 'aRepo';
		$m1 = new RedisModelMapping\MockModelTest1();
		$m2 = new RedisModelMapping\MockModelTest2();
		$inst = new AfterFind(
			array('OrderedSet'=>$orderedSet,
				'modelRepository' => $repo
			)
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
		$inst->setRepository('modelRepository');
		$inst->afterFind($m1);

		$this->assertEquals($m1->attr1(),$m2);

	}
	public function testShouldGetTheSetAndSetIntoModelIfMany(){
		$orderedSet = m::mock('stdClass,\ArrayAccess');
		$repo = 'aRepo';
		$m1 = new RedisModelMapping\MockModelTest1();
		$m2 = new RedisModelMapping\MockModelTest2();
		$inst = new AfterFind(
			array('OrderedSet'=>$orderedSet,
				'modelRepository' => $repo
			)
		);
		$inst->setOneToOne(false);
		$orderedSet->shouldReceive('setReferencedModel')
			->with($m1)
			->once();
		$orderedSet->shouldReceive('setRepository')
			->with($repo)
			->once();
		$inst->setRelationshipAttribute('attr1');
		$inst->setRepository('modelRepository');
		$inst->afterFind($m1);

		$this->assertEquals($m1->attr1(),$orderedSet);

	}

}?>
