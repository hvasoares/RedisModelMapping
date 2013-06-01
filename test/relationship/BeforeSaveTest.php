<?php
namespace switch5\domain\relationship;
use \Mockery as m;
require_once 'relationship/BeforeSave.php';
require_once 'test/MockModelTest.php';
use \switch5\domain;
use ArrayAccess;
class BeforeSaveTest
	extends \PHPUnit_Framework_Testcase{
	public function setUp(){
	}
	public function testShouldCheckIfTheReference(){
		$repo = m::mock('repo');
		$m = m::mock('mapper');
		$o = m::mock("stdClass,ArrayAccess");
		$r = array(
			'Mapper' => $m,
			'OrderedSet' => $o,
			'modelRepository' => $repo
		);

		$inst = new BeforeSave($r);
		$inst->setRepository('modelRepository');
		
		$inst->setRelationshipAttribute('attr1');

		$m1 = new domain\MockModelTest1();
		$m2 = new domain\MockModelTest2();
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
		$inst->setOneToOne(1);
		$o->shouldReceive('setRepository')
			->with($repo)
			->once();
		$o->shouldReceive("setReferencedModel")
			->with($m1)
			->once();
		$o->shouldReceive('offsetUnset')
			->with(0)
			->once();
		$o->shouldReceive('offsetGet')
			->with(0)
			->andReturn(new domain\MockModelTest1())
			->atLeast(1);
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
