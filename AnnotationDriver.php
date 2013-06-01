<?php
namespace switch5\domain;
interface AnnotationDriver{
	public function getPropertyAnnotations($obj,$property);
	public function getClassAnnotationsFromObject($obj);
}
?>
