<?php
namespace switch5\domain;
interface PropertyAnnotation{
	public function isTransient();
	public function setPropertyName($v);
}
