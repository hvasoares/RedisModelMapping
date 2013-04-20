<?php
namespace switch5\domain;
require_once 'libs/commons/Registry.php';
require_once 'ZsetPushOperation.php';
require_once 'RedisOrderedSet.php';
require_once 'RedisZsetHelper.php';
require_once 'ZsetPushOperation.php';
use switch5\commom\Registry;
class GlueCode{
	public function getRegistry($top=null){
		$r = new Registry($top);

		$r['OrderedSet'] = function($r){
			return new RedisOrderedSet(
				$r['ZsetHelper']
			);
		};

		$r['ZsetHelper'] = function($r){
			$h = new RedisZsetHelper($r['Redis']);	
			$h->setOperations(array(
				'push' => $r['ZsetPush']
			));
			return $h;
		};

		$r['ZsetPush'] = new ZsetPushOperation(
			$r['Redis']
		);

		return $r;
	}
}
?>
