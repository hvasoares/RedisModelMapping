<?php
namespace hvasoares\RedisModelMapping\weakEntity;
require_once __DIR__.'/../ExtendedRepositoryListenerAdapter.php';
class BeforeSaveListener extends 
	\hvasoares\RedisModelMapping\ExtendedRepositoryListenerAdapter{
	public function __construct($childClassName,$fatherclass){
		$this->c = $childClassName;
		$this->f = $fatherclass;
		$this->isSaving = null;
	}
	public function beforeSave($model){
		$this->isSaving=true;
		return $model;

	}
	public function afterSave($m){
		$this->isSaving = false;
		return $m;
	}
	public function isSaving(){
		return $this->isSaving;
	}
}
?>
