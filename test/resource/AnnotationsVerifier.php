<?php
$common_dir= __DIR__.'/../../../libs/common/lib/Doctrine/Common';
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
"Annotation/Target.php"
);

require "$common_dir/Lexer.php";
foreach($required as $f)
	require "$annotation_dir/$f";

use \Doctrine\Common\Annotations as a;

class AnnotationsVerifier{
	public function __construct(){
		$this->reader = new a\FileCacheReader(
			new a\AnnotationReader(),
			'/tmp/',
			$debug = true
		);

		$this->registry = new a\AnnotationRegistry();
	}
	public function getReader(){
		return $this->reader;
	}

	public function getRegistry(){
		return $this->registry;
	}
}
?>
