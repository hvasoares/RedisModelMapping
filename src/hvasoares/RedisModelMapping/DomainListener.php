<?php
namespace hvasoares\RedisModelMapping;
require_once 'ExtendedRepositoryListener.php';
class DomainListener implements ExtendedRepositoryListener{
	public function __construct($r){
		$this->r =$r;
		$this->allListeners = array();
	}
	public function add($listener){
		$modelName=get_class($listener->getModelClass());
		if(!isset($this->allListeners[$modelName]))
			$this->allListeners[$modelName] = 
			$this->r['listenerChain'];
		$listener->setRegistry($this->r);
		$this->allListeners[$modelName]->add($listener);
	}
	public function beforeFind($model){
	}
	public function beforeSave($model){
		return $this->genericMethod('beforeSave',$model);
	}
	public function afterFind($model){
		return $this->genericMethod('afterFind',$model);
	}
	public function afterSave($model){
		return $this->genericMethod('afterSave',$model);
	}
	public function deleteListener($model){
		return $this->genericMethod('deleteListener',$model);
	}
	private function genericMethod($method,$model){
		$class = get_class($model);
		if(isset($this->allListeners[$class])){
			$lc = $this->allListeners[$class];
			return call_user_func_array(
				array($lc,$method),
				array($model)
			);
		}
		return $model;

	}
}
?>
