<?php
namespace switch5\domain;
require_once 'test/RepositoryStrategyBehaviour.php';
require 'UserRepositoryStrategy.php';
use \Mockery as m;
class UserRepositoryStrategyTest extends RepositoryStrategyBehaviour{
	public function getSampleModel(){
		return new User();
	}	
	public function getAttrs(){
		return array('created_time','modified_time');
	}
	public function getRepositoryStrategy(){
		return new UserRepositoryStrategy();
	}
}
?>
