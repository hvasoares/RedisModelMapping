<?php
namespace switch5\domain;
use \Mockery as m;
require 'UserRepository.php';
class UserRepositoryTest extends \PHPUnit_Framework_Testcase{
	public function itShouldSaveAndUpdateAUser(){
		$repo = mock('repository');

		$repo->should	
		$inst = new UserRepository($repo);
	}
}
?>
