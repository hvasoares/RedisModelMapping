<?php
namespace switch5\domain\hashedId;
require_once __DIR__.'/../ExtendedRepositoryListenerAdapter.php';
use switch5\domain;
class Generator	extends domain\ExtendedRepositoryListenerAdapter
{
	public function __construct(&$registry){
		$this->r = &$registry;
	}
	public function setBaseProperty(){
		$this->attr = func_get_args();
	}
	public function beforeSave($model){
		$m = $this->r['Mapper'];
		$redis = $this->r['Redis'];
		$zsetPush = $this->r['ZsetPush'];
		$zsetExists= $this->r['ZsetExists'];

		$modelName = get_class($model);
		$zsetname = $modelName."_hashed_generator";
		$type =$redis->type($zsetname);
		if(!$type || $type==4){
			$array = $m->getArray($model);
			$hash=sha1($this->concatAttrs($array)
				.$this->r['sha1_salt']
			);
			$array['id'] =	$zsetExists->operate(
				$zsetname,
				$hash
			);
			if(!$array['id'])
				$array['id'] = $zsetPush->operate(
					$zsetname,
					$hash
				);
			$m->arrayToModel($model,$array);
			$this->r['newest_id'] = $array['id'];
			return $model;
		}
	}
	public function concatAttrs($array){
		$result='';
		foreach($this->attr as $attr)
			$result.=$array[$attr];
		return $result;
	}
}
?>
