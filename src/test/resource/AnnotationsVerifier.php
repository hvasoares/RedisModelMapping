<?php
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
