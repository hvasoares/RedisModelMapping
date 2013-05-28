<?php
namespace switch5\domain;
interface RepositoryStrategy{
	public function createNewModel();
	public function getSchemaClosure();
	public function getValidation();
}
?>
