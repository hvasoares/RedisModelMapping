<?php
namespace switch5\domain;
require_once __DIR__.'/../commom/Registry.php';
require_once 'SexualityRepositoryStrategy.php';
require_once 'UserRepositoryStrategy.php';
require_once 'LocalizationRepositoryStrategy.php';
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
			$hashedId = $r['hashedIdBuilder'];


			$rls1 = $r['unidirectionalRelationship'];
			$rls2 = $r['unidirectionalRelationship'];
			
			$r['localizationRepository']=$rls2->setRelationshipAttribute('first_user')
				->get(
					$rls1->setRelationshipAttribute('top_location')
						->get( $hashedId->baseProperty('name','top_location_id')
							->get($r['repositoryBuilder']
								->addListener($lc)
							->strategy(new LocalizationRepositoryStrategy())
						)
					)
				)->get();

			$rls1->setRepository($r['localizationRepository']);

			$rls2->setRepository($r['userRepository']);



			return	$r['localizationRepository'];
		};


		return $r;
	}
}
?>
