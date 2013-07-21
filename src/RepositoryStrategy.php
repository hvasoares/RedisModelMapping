<?php
namespace hvasoares\RedisModelMapping;
interface RepositoryStrategy{
	public function createNewModel();
	public function getSchemaClosure();
	public function getValidation();
}
?>
