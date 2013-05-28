<?php
namespace switch5\domain;
abstract class SchemaDefinitionProxy{
	public function setModel($v){
		$this->model = $v;
	}

	public function modelName($v){
		$this->model->modelName($v);
	}

	public function attr($v){
		$this->model->attr($v);
	}

	public function incrKey($v){
		$this->model->incrKey($v);
	}

	public function setValidationClosure($v){
		$this->model->setValidationClosure($v);
	}
}
?>
