<?php
namespace switch5\domain;
use \Mockery as m;
require_once 'LocalizationRepositoryStrategy.php';
require_once 'test/RepositoryStrategyBehaviour.php';
class LocalizationRepositoryStrategyTest extends
	RepositoryStrategyBehaviour{
	public function getSampleModel(){
		return new Localization();
	}
	public function getRepositoryStrategy(){
		return new LocalizationRepositoryStrategy();
	}

	public function getAttrs(){
		return array('name');
	}
}
?>
