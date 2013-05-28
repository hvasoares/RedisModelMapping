<?php
namespace switch5\domain\hashedId;
require_once __DIR__.'/../ExtendedRepositoryListenerAdapter.php';
class KeyUpdater extends 
	\switch5\domain\ExtendedRepositoryListenerAdapter
{
	public function __construct(&$registry){
		$this->r = &$registry;
	}

	public function beforeSave($model){
		$r = $this->r['Redis'];
		$new_id = $this->r['newest_id'];
		while($r->incr($this->r['modelKey'])<$new_id);
		unset($this->r['newest_id']);
		return $model;
	} 
}
?>
