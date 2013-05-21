<?php
namespace switch5\domain;
interface ExtendedRepositoryListener{
	public function beforeFind($id);
	public function afterFind($modelRecentFound);
	public function beforeSave($model);
	public function afterSave($model);
	public function deleteListener($model);
}
?>
