<?php
namespace switch5\domain\hashedId;
require_once __DIR__.'/../ExtendedRepositoryListenerAdapter.php';
use switch5\domain;
class Generator	extends domain\ExtendedRepositoryListenerAdapter
{
	public function __construct(&$registry){
		$this->r = &$registry;
	}
	public function beforeSave($model){
		$r = $this->r;
		$m = $r['Mapper'];
		$redis = $r['Redis'];
		$zsetPush = $r['ZsetPush'];
		$zsetExists= $r['ZsetExists'];

		$modelName = get_class($model);
		$type =$redis->type($r['zsetkey']);
		if(!$type || $type==4){
			$array = $m->getArray($model);
			$hash=sha1($this->concatAttrs($array)
				.$this->r['sha1_salt']
			);
			$array['id'] =	$zsetExists->operate(
				$r['zsetkey'],
				$hash
			);

			if(!$array['id'])
				$array['id'] = $zsetPush->operate(
					$r['zsetkey'],
					$hash
				);
			$m->arrayToModel($model,$array);
			$this->r['newest_id'] = $array['id'];
			return $model;
		}
	}
	public function concatAttrs($array){
		$result='';
		foreach($this->r['attrs'] as $attr)
			$result.=$array[$attr];
		return $result;
	}
}
?>
