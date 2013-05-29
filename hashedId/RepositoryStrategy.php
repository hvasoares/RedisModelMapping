<?php
namespace switch5\domain\hashedId;
require_once __DIR__.'/../ProxyRepositoryStrategy.php';
class RepositoryStrategy extends
	\switch5\domain\ProxyRepositoryStrategy{
	public function __construct($innerStrategy,&$registry){
		parent::__construct($innerStrategy);
		$this->r=&$registry;
	}
	public function setSchemaClosureListener($v){
		$this->schemaL = $v;
	}
	public function getSchemaClosure(){
		$schemaL = $this->schemaL;
		$innerClosure = parent::getSchemaClosure();
		$obj = $this;

		return function($m) 
			use($schemaL,$innerClosure,$obj){
			$schemaL->setModel($m);
			$innerClosure($schemaL);
			$obj->setIncrKey();
		};
	}

	public function setIncrKey(){
		$key=$this->schemaL->getIncrKey();
		$this->r['modelKey'] =$key;
		$this->r['zsetkey']= $key.'_hashed_generator';
	}
}	
?>
