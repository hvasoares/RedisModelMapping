<?php
namespace hvasoares\RedisModelMapping;
require_once __DIR__."/ExtendedRepositoryListenerAdapter.php"; 
class PHPLombokListener extends 
	ExtendedRepositoryListenerAdapter{
	public function __construct($lombokR){
		$this->r =$lombokR;
	}
	public function afterSave($model){
		$r= $this->r['childClassGenerator']
			->generate($model);
		return $r;
	}

	public function beforeSave($model){
		if(method_exists($model,'getAnnotatedObject'))
			return $model->getAnnotatedObject();	
		return $model;
	}

	public function afterFind($model){
		return $this->r['childClassGenerator']
			->generate($model);
	}

	public function afterCreate($model){
		return $this->afterSave($model);
	}
}
?>
