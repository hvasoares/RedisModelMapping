<?php
namespace switch5\domain;
require_once __DIR__.'/../commom/Registry.php';
require_once 'SexualityRepositoryStrategy.php';
require_once 'UserRepositoryStrategy.php';
require_once 'ExtendedRepository.php';
use switch5\commom\Registry;
class GlueCodeRepository{
	public function getRegistry($top){
		$r = new Registry($top);

		$r['sexualityRepository'] = function($r){
/*			$wkl = new WeakEntityListener(
				'Sexuality',
				'User'
			);
			$wers =	new WeakEntityRepositoryStrategy(
				new SexualityRepositoryStrategy(),
				$wkl
			);
			$result = new ExtendedRepository(
				$r['Repository'],
				$wers,	
				$wkl
			);*/
			$hashedBuilder = $r['hashedIdBuilder'];
			$repoBuilder = $r['repositoryBuilder'];
			$result = $hashedBuilder->baseProperty(
				'sex','interestedSex'
			)->get($repoBuilder->strategy(
				new SexualityRepositoryStrategy())
			)->get();
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
		$r['localizationRepository']=function($r){
			$lc=$r['listenerChain'];
			$result = new ExtendedRepository(
				$r['Repository'],
				new LocalizationRepositoryStrategy(),
				$lc
			);

			$rls1 = $r['unidirectionalRelationship'];
			$rls1->setRelationshipAttribute('top_location');
			$rls1->setRepository($result);

			$rls2 = $r['unidirectionalRelationship'];
			$rls2->setRelationshipAttribute('first_user');
			$rls2->setRepository($r['userRepository']);

			$lc->add($rls2);
			$ls->add($rls1);
			$r['localizationRepository']=$result;
			return $restult;
		};


		return $r;
	}
}
?>
