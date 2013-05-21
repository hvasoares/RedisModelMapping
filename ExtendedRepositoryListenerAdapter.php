<?php
namespace switch5\domain;
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
		
	}

	public function deleteListener($model){
		
	}
}
?>
