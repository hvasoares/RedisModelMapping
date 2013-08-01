<?php
namespace hvasoares\RedisModelMapping;
require_once 'ExtendedRepositoryListenerAdapter.php';
use Symfony\Component\Validator\Validation;
class AnnotationsModelValidator 
	extends ExtendedRepositoryListenerAdapter{

	public function __construct(){
		$this->val = Validation::createValidatorBuilder()
			->enableAnnotationMapping()
			->getValidator();
	}

	public function beforeSave($model){
		$val = $this->val->validate($model);
		if($val->count()>0)
			throw new \Exception();
		return $model;
	}
}
