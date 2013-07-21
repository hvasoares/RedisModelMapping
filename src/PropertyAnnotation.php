<?php
namespace hvasoares\RedisModelMapping;
interface PropertyAnnotation{
	public function isTransient();
	public function setPropertyName($v);
}
