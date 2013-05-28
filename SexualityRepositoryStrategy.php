<?php
namespace switch5\domain;
require_once 'Sexuality.php';
require_once 'InvalidSexException.php';
class SexualityRepositoryStrategy{
	private $val;
	public function createNewModel(){
		return new Sexuality();
	}	
	public function getSchemaClosure(){
		$modelName = get_class($this->createNewModel());
		$val = $this->getValidation();
		return function($model) use($modelName,$val){
			$model->modelName($modelName);
			$model->attr('sex');
			$model->attr('interestedSex');
			$model->incrKey("switch5\domain\Sexuality_key");
			$model->setValidationClosure($val);
		};
	}
	public function getValidation(){
		if($this->val)
			return $this->val;
		$this->val = function($raw){
			$valids = array('woman','man');	
			if(!in_array($raw['sex'],$valids))
				throw new InvalidSexException();
			if(!in_array($raw['interestedSex'],$valids))
				throw new InvalidSexException();
			return true;
		};
		return $this->val;
	}
}
?>	
