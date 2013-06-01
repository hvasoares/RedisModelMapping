<?php
namespace switch5\domain;
require_once 'AnnotatedPropertyConsulter.php';
require_once 'PropertyAnnotation.php';
require_once 'test/MockModelTest.php';
use \Mockery as m;
class AnnotatedPropertyConsulterTest extends \PHPUnit_Framework_Testcase{
	public function testShouldReturnThePersistentsPropertys(){
		$object = new MockModelTest1();
		$inst = new AnnotatedPropertyConsulter();

		$inst->setAnnotationDriver($annoDriver=m::mock('driver'));

		$annoDriver->shouldReceive(
			'getPropertyAnnotations'
		)->with($object,'attr2')
		->andReturn(array())
		->times(2);

		$annoDriver->shouldReceive(
			'getPropertyAnnotations'
		)->with($object,'attr1')
		->andReturn(array(
			$noT = m::mock('noT','\stdClass,'.
				'switch5\domain\PropertyAnnotation'
			),
			$yesT =  m::mock('yesT','\stdClass,'.
			'switch5\domain\PropertyAnnotation'
			)
		))
		->times(2);

		$yesT->shouldReceive('isTransient')
			->andReturn(true)
			->once();
		$noT->shouldReceive('isTransient')
			->andReturn(false)
			->once();

		$allPAnnotation = array($noT,$yesT);
		foreach($allPAnnotation as $a){
			$a->shouldReceive('setPropertyName')
				->with('attr1')
				->once();
		}	

		$this->assertEquals(	
			$inst->getPersistentProperties($object),
			array('attr2')
		);
		$this->assertEquals(
			array($noT,$yesT),
			$inst->getAllAnnotations($object,'attr1')
		);
	}
}
?>
