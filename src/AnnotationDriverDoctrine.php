<?
namespace hvasoares\RedisModelMapping;
$common_dir= __DIR__.'/../libs/common/lib/Doctrine/Common';
$annotation_dir = "$common_dir/Annotations";

$required = array(
"Reader.php",
"DocParser.php",
"PhpParser.php",
"DocLexer.php",
"TokenParser.php",
"AnnotationException.php",
"AnnotationReader.php",
"FileCacheReader.php",
"AnnotationRegistry.php",
"Annotation/Target.php",
"CachedReader.php",
"../Cache/Cache.php",
"../Cache/CacheProvider.php",
"../Cache/ArrayCache.php"
);
require_once 'AnnotationDriver.php';
require "$common_dir/Lexer.php";
foreach($required as $f)
	require "$annotation_dir/$f";

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
			if(strpos($class,"\Symfony\Component\Validator\Constraints")===0){
				$part = explode("\\",$class);
				$classname = array_pop($part);
				require_once __DIR__."/../libs/Validator/Constraints/$classname.php";
				require_once __DIR__."/../libs/Validator/Constraints/$classname"."Validator.php";
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
