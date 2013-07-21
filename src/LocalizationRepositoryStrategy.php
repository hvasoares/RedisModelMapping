<?php
namespace hvasoares\RedisModelMapping;
require_once 'Localization.php';
class LocalizationRepositoryStrategy{
	private $val; 
	public function createNewModel(){
		return new Localization();
	}
	public function getSchemaClosure(){
		$modelName = get_class($this->createNewModel());
		$val = $this->getValidation();
		return function($model) use($modelName,$val){
			$model->modelName($modelName);	
			$model->attr('name');
			$model->setValidationClosure($val);
			$model->incrKey($modelName."_key");
		};
	}
	public function getValidation(){
		if($this->val)
			return $this->val;	
		$this->val = function($raw){
			return true;
		};
		return $this->val;
	}
}
?>
