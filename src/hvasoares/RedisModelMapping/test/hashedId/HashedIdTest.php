<?php
namespace hvasoares\RedisModelMapping\hashedId;
require_once 'hashedId/HashedId.php';
require_once 'test/resource/AnnotationsVerifier.php';
use \Mockery as m;
class HashedIdTest extends \PHPUnit_Framework_Testcase{
	public function testAfterConstructedShouldConfigureTheBuilder(){
		$instance = new HashedId();
		$instance->attrs = array('attr1','attr2');
		$instance->setRegistry(array(
				'hashedIdBuilder' => $builder = m::mock('builder'))
		);

		$builder->shouldReceive('baseProperty')
			->with('attr1','attr2')
			->once();

		$this->assertEquals(
			$instance->getBuilder(),
			$builder
		);
	}
	public function testAnnotations(){
		$verifier = new \AnnotationsVerifier();
		$instance = new HashedId();
		$rf = new \ReflectionObject($instance);
		$classAnnotations =$verifier->getReader()
			->getPropertyAnnotations(
				$rf->getProperty('attrs')
			);

		foreach($classAnnotations as $annot){
			echo get_class($annot);
		}
	}
}
