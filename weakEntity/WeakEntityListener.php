<?php
namespace switch5\domain\weakEntity;
require_once __DIR__.'/../ExtendedRepositoryListenerAdapter.php';
class BeforeSaveListener extends 
	\switch5\domain\ExtendedRepositoryListenerAdapter{
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
