<?
namespace hvasoares\RedisModelMapping;
use ReflectionObject, ReflectionProperty;
use \Doctrine\Common\Annotations as a;
class AnnotationDriverDoctrine implements AnnotationDriver{
	public function __construct(){
		$this->reader = new a\FileCacheReader(
			new a\AnnotationReader(),
			'/tmp/',
			$debug = true
		);

		a\AnnotationRegistry::registerLoader(function($class){
			$full_dir = REDIS_MODEL_MAPPING_SYMFONY_VALIDATOR_DIR
				."/Symfony/Component/Validator/Constraints";
			if(strpos($class,"\Symfony\Component\Validator\Constraints")===0){
				$part = explode("\\",$class);
				$classname = array_pop($part);
				require_once "$full_dir/$classname.php";
				require_once "$full_dir/$classname"."Validator.php";
				return true;
			}
			return false;
		});

		$this->registry = new a\AnnotationRegistry();
	}
	public function getPropertyAnnotations($obj,$propertyName){
			$obj =new ReflectionObject($obj);
			return $this->reader->getPropertyAnnotations($obj->getProperty($propertyName));
	}

	public function getClassAnnotationsFromObject($obj){
		return $this->reader->getClassAnnotations(
			new ReflectionObject($obj)
		);
	}

	public function registerAnnotationFile($file){
		$this->registry->registerFile($file);
	}
}
?>
