<?php
namespace switch5\domain;
require_once 'SchemaDefinitionProxy.php';
class ModelIncrKeyListener extends SchemaDefinitionProxy{

	public function incrKey($v){
		$this->key = $v;
		parent::incrKey($v);
	}

	public function getIncrKey(){
		return $this->key;
	}
}
?>

