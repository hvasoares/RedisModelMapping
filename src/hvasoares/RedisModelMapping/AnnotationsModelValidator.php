<?php
namespace hvasoares\RedisModelMapping;
$validator_dir = __DIR__.'/../libs/Validator';

$val_files = array(
	"ValidatorInterface.php",
	"Validator.php",
	"ValidationVisitorInterface.php",
	"GlobalExecutionContextInterface.php",
	"Constraint.php",
	"ConstraintViolationInterface.php",
	"ConstraintViolation.php",
	"ConstraintViolationListInterface.php",
	"ConstraintViolationList.php",
	"ValidationVisitor.php",
	"Validation.php",
	"ValidatorBuilderInterface.php",
	"ValidatorBuilder.php",
	"Mapping/Loader/LoaderInterface.php",
	"Mapping/Loader/AnnotationLoader.php",
	"ClassBasedInterface.php",
	"PropertyMetadataContainerInterface.php",
	"ExecutionContextInterface.php",
	"ExecutionContext.php",
	"MetadataInterface.php",
	"Mapping/ElementMetadata.php",
	"Mapping/ClassMetadata.php",
	"ConstraintValidatorInterface.php",
	"ConstraintValidator.php",
	"PropertyMetadataInterface.php",

	"Mapping/MemberMetadata.php",
	"Mapping/PropertyMetadata.php",
	"MetadataFactoryInterface.php",
	"../Translation/TranslatorInterface.php",
	"DefaultTranslator.php",
	"ConstraintValidatorFactoryInterface.php",
	"ConstraintValidatorFactory.php",
	"Mapping/ClassMetadataFactoryInterface.php",
	"Mapping/ClassMetadataFactory.php"

);

foreach($val_files as $f)
	require_once "$validator_dir/$f";

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
