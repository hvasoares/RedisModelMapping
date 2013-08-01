<?php
namespace hvasoares\RedisModelMapping\hashedId;
require_once __DIR__.'/../ExtendedRepositoryListenerAdapter.php';
class BeforeSaveIdTunning extends
	\hvasoares\RedisModelMapping\ExtendedRepositoryListenerAdapter{
	public function __construct($registry){
		$this->r = $registry;	
	}
	public function beforeSave($model){
		$m = $this->r['Mapper'];		
		$zexists = $this->r['ZsetExists'];
		$array = $m->getArray($model);
		$hash=sha1($this->concatAttrs($array)
			.$this->r['sha1_salt']
		);
		if($zexists->operate(
			$this->r['zsetkey'],
			$hash
		)){
			$array['id'] = $this->r['Redis']->zscore(
				$this->r['zsetkey'],
				$hash
			);
			$m->arrayToModel($model,$array);
		}

		return $model;
	}
	public function concatAttrs($array){
		$attrs = $this->r['attrs'];
		$result='';
		foreach($attrs as $attr)
			$result.=$array[$attr];
		return $result;
	}
}
?>
