<?php
namespace switch5\domain;
require_once 'ExtendedRepositoryListenerAdapter.php';
class WeakEntityListener extends ExtendedRepositoryListenerAdapter{
	public function __construct($childClassName,$fatherclass){
		$this->c = $childClassName;
		$this->f = $fatherclass;
	}
	public function beforeSave($model){
		if($model->id())
			return $model;

		throw new \Exception(
			'Objects of '. $this->c.
			" must share id from " .$this->f
		);
	}
}
?>
