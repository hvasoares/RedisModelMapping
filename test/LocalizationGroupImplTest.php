<?php
namespace switch5\domain;
require_once 'LocalizationGroupImpl.php';
use \Mockery as m;
class LocalizationGroupTest extends \PHPUnit_Framework_Testcase{
	public function testShouldNextUserFromGroup(){
		$loc = new Localization();
		$usersSet = m::mock('stdClass,ArrayAccess');
		$inst = new LocalizationGroupImpl($loc);
		$inst->setUsers($usersSet);

		$usersSet->shouldReceive('offsetGet')
			->with(0)
			->andReturn('a_user')
			->times(1);
		$usersSet->shouldReceive('offsetUnset')
			->with(0)
			->times(1);	

		$this->assertEquals(
			$inst->nextUser(),'a_user'
		);
		$usersSet->shouldReceive('offsetSet')
			->with("",'new_user')
			->times(1);
		$inst->addUser('new_user');
	}
}
?>
