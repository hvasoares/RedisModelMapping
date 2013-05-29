<?php
namespace switch5\domain;
use \Mockery as m;
require_once 'UnidirectionalRelationshipBeforeSave.php';
require_once 'test/MockModelTest.php';
class UnidirectionalRelationshipBeforeSaveTest
	extends \PHPUnit_Framework_Testcase{
	public function setUp(){
	}
	public function testShouldCheckIfTheReference(){
		$repo = m::mock('repo');
		$m = m::mock('mapper');
		$o = m::mock("stdClass,\ArrayAccess");
		$r = array(
			'Mapper' => $m,
			'OrderedSet' => $o
		);

		$inst = new UnidirectionalRelationshipBeforeSave($r);
		$inst->setRepository($repo);
		
		$inst->setRelationshipAttribute('attr1');

		$m1 = new MockModelTest1();
		$m2 = new MockModelTest2();
		$m1->attr1($m2);

		$m->shouldReceive('getArray')
			->with($m1)
			->andReturn(array(
				'id' => 'someId',
				'attr1' => $m2
			));

		$repo->shouldReceive('find')
			->with('mockModelTest2Id')
			->andReturn($m2)
			->once();
		$inst->setCardinality(1);
		$o->shouldReceive('setRepository')
			->with($repo)
			->once();
		$o->shouldReceive("setReferencedModel")
			->with($m1)
			->once();
		$o->shouldReceive('offsetUnset')
			->with(0)
			->once();
		$o->shouldReceive('offsetSet')
			->with('',$m2)
			->once();
		$this->assertEquals(
			$inst->beforeSave($m1),
			$m1
		);


	}
}
?>
