<?php
namespace switch5\domain;
class GenericRepositoryStrategy{
	private $val;
	public function attrs(){
		$this->attrs = func_get_args();
	}

	public function setClass($v){
		$this->class = $v;
	}

	public function createNewModel(){
		return new $this->class();	
	}

	public function getSchemaClosure(){
		$modelN = $this->class;
		$attrs = $this->attrs;
		$val = $this->getValidation();
		return function($model) use($attrs,$modelN,$val){
			$model->modelName($modelN);
			foreach($attrs as $attr)
				$model->attr($attr);
			$model->setValidationClosure($val);
			$model->incrKey($modelN."_key");
		};	
	}

	public function getValidation(){
		if($this->val)
			return $this->val;
		return $this->val =function($raw){
			return true;
		};	
	}
}
?>
