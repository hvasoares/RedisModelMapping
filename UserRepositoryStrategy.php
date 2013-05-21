<?php
namespace switch5\domain;
require_once 'validations.php';
require_once 'User.php';
class UserRepositoryStrategy{
	private $val;
	public function createNewModel(){
		return new User();
	}

	public function getSchemaClosure(){
		$modelName = get_class($this->createNewModel());
		$val = $this->getValidation();
		return function($model) use($modelName,$val){
			$model->modelName($modelName);
			$model->incrKey($modelName."_key");
			$model->attr("created_time");
			$model->attr("modified_time");
			$model->setValidationClosure($val);
		};
	}

	public function getValidation(){
		if($this->val)
			return $this->val;
		$this->val = function($raw){
			v\isInteger($raw['created_time']);
			v\isInteger($raw['modified_time']);
			return true;
		};
		return $this->val;
	}
}

?>
