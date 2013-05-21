<?php
namespace switch5\domain;
require_once 'libs/commons/Registry.php';
require_once 'SexualityRepositoryStrategy.php';
require_once 'UserRepositoryStrategy.php';
require_once 'ExtendedRepository.php';
use switch5\commom\Registry;
class GlueCodeRepository{
	public function getRegistry($top){
		$r = new Registry($top);

		$r['sexualityRepository'] = function($r){
			$result = new ExtendedRepository(
				$r['Repository'],
				new SexualityRepositoryStrategy(),
				new WeakEntityListener(
					'Sexuality',
					'User'
				)
			);
			$r['sexualityRepository']=$result;
			return $result;
		};
		$r['userRepository'] = function($r){
			$result = new ExtendedRepository(
				$r['Repository'],
				new UserRepositoryStrategy(),
				$r['listenerChain']
			);
			$r['userRepository']=$result;
			return $result;

		};

		return $r;
	}
}
?>
