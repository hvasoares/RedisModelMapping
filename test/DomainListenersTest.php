<?php
namespace switch5\domain;
require_once 'DomainListener.php';
require_once 'test/MockModelTest.php';
use \Mockery as m;
class DomainListenerTest extends \PHPUnit_Framework_Testcase{
	public function testExecuteListenerForModel(){
		$r = m::mock('stdClass,\ArrayAccess');

		$inst = new DomainListener($r);

		$r->shouldReceive('offsetGet')
			->with('listenerChain')
			->andReturn(
				$chain1 = m::mock('chain'),
				$chain2 = m::mock('chain2')
			)->times(2);

		$obj1 = new MockModelTest1();
		$l1 = m::mock('listener');
		$l1->shouldReceive('getModelClass')
			->andReturn(get_class($obj1))
			->once();
		$l1->shouldReceive('setRegistry')
			->with($r)
			->once();
		$chain1->shouldReceive('add')
			->with($l1)
			->times(1);
		$obj2 = new MockModelTest2();
		$l2 = m::mock('listener');
		$l2->shouldReceive('getModelClass')
			->andReturn(get_class($obj2))
			->once();
		$l2->shouldReceive('setRegistry')
			->with($r)
			->once();

		$chain2->shouldReceive('add')
			->with($l2)
			->times(1);

		$inst->add($l1);
		$inst->add($l2);

		$methods = array('beforeFind','beforeSave','afterSave','afterFind', 'deleteListener');

		$listeners= array(
			get_class($obj1)=>$chain1,
			get_class($obj2)=>$chain2
		);
		$objs = array(
			get_class($obj1)=>$obj1,
			get_class($obj2)=>$obj2
		);
		foreach($listeners as $oc=>$l){
			$obj = $objs[$oc];
			foreach($methods as $m){
				$l->shouldReceive($m)
					->with($obj)
					->andReturn($obj)
					->once();
				$this->assertEquals(
					$obj,
					call_user_func(
						array($inst,$m),
						$obj
					)
				);
			}
		}
	}
}
?>
