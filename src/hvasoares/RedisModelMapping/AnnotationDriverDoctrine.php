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

		$this->registry = new a\AnnotationRegistry();
		$this->registry->registerNamespace("\\Symfony\\Component\\Validator\\Constraints");
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
