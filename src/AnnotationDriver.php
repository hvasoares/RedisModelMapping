<?php
namespace hvasoares\RedisModelMapping;
interface AnnotationDriver{
	public function getPropertyAnnotations($obj,$property);
	public function getClassAnnotationsFromObject($obj);
}
?>
