<?php
namespace hvasoares\RedisModelMapping;
require_once __DIR__."/ExtendedRepositoryListenerAdapter.php"; 
class PHPLombokListener extends 
	ExtendedRepositoryListenerAdapter{
	public function __construct($lombokR){
		$this->r =$lombokR;
	}
	public function afterSave($model){
		return $this->r['childClassGenerator']
			->generate($model);
	}

	public function beforeSave($model){
		return $model->getAnnotatedObject();	
	}

	public function afterFind($model){
		return $this->r['childClassGenerator']
			->generate($model);
	}
}
?>
