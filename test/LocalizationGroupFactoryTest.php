<?php
namespace switch5\domain;
require_once 'LocalizationGroupFactory.php';
require_once 'LocalizationGroupImpl.php';
use \Mockery as m;
class LocalizationGroupFactoryTest extends \PHPUnit_Framework_Testcase{
	public function testShouldCreateALocalizationGroup(){
		$repo = m::mock('repo');
		$local = m::mock('switch5\domain\Localization');
		$set = m::mock('OrderedSet');
		$reg = array(
			'LocalizationRepository' => $repo,
			'UserRepository' => 'a_userRepo',
			'OrderedSet' => $set
		);

		$instance = new LocalizationGroupFactory($reg);

		$repo->shouldReceive('find')
			->with('a_id')
			->times(1)
			->andReturn($local);
		$set->shouldReceive('setRepository')
			->with($reg['UserRepository'])
			->times(1);
		$set->shouldReceive('setReferencedModel')
			->with($local)
			->times(1);
		$newObj =$instance->create('a_id');
		$this->assertEquals($local,$newObj->getLocal());
		$this->assertEquals($set,$newObj->getUsers());
	}	
}
?>
