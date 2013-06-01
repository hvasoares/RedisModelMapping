<?php
namespace switch5\domain;
require_once 'ExtendedRepositoryListenerAdapter.php';
require_once 'DomainListenerInterface.php';
class UserIsReadyChecker 
	extends ExtendedRepositoryListenerAdapter
	implements DomainListenerInterface{
	public function setRegistry($v){
		$this->r = $v;
	}
	public function getModelClass(){
		return new User();
	}	
	public function afterSave($model){
		if(is_null($model->sexuality()))
			return $model;
		if(is_null($model->localization()))
			return $model;
		$repo = $this->r['localizationGroupRepository'];
		$locGroup = $repo->createNewModel();
		$locGroup->sexuality($model->sexuality());
		$locGroup->localization($model->localization());
		$repo->save($locGroup);
		$locGroup->addUser($model);
		return $model;
	}
}
