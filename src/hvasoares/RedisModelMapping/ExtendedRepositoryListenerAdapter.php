<?php
namespace hvasoares\RedisModelMapping;
require_once 'ExtendedRepositoryListener.php';
abstract class ExtendedRepositoryListenerAdapter{
	public function beforeFind($id){
		return $id;
	}	
	public function afterFind($model){
		return $model;
	}

	public function beforeSave($model){
		return $model;
	}

	public function afterSave($model){
		return $model;		
	}

	public function deleteListener($model){
		
	}

	public function afterCreate($model){
		return $model;
	}
}
?>
