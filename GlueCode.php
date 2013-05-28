<?php
namespace switch5\domain;
require_once __DIR__.'/../commom/Registry.php';
require_once 'ZsetPushOperation.php';
require_once 'RedisOrderedSet.php';
require_once 'RedisZsetHelper.php';
require_once 'ZsetPushOperation.php';
require_once 'ZsetExistsOperationStrategy.php';
require_once 'ListenerChain.php';
require_once 'GlueCodeRepository.php';
require_once 'UnidirectionalRelationship.php';
require_once 'UnidirectionalRelationshipBeforeSave.php';
require_once 'UnidirectionalRelationshipAfterFind.php';
require_once 'weakEntity/Builder.php';
require_once 'hashedId/Builder.php';
require_once 'RepositoryBuilder.php';
use switch5\commom\Registry;
class GlueCode{
	public function getRegistry($top=null){
		$r = new Registry($top);

		$r['listenerChain'] = function($r){
			return new ListenerChain();
		};

		$r['OrderedSet'] = function($r){
			return new RedisOrderedSet(
				$r['ZsetHelper']
			);
		};

		$r['weakEntityBuilder'] = function($r){
			return new weakEntity\Builder();
		};

		$r['hashedIdBuilder'] = function($r){
			return new hashedId\Builder($r);
		};

		$r['repositoryBuilder'] = function($r){
			return new RepositoryBuilder($r);
		};

		$r['ZsetHelper'] = function($r){
			$h = new RedisZsetHelper($r['Redis']);	
			$h->setOperations(array(
				'push' => $r['ZsetPush'],
				'exists' => $r['ZsetExists']
			));
			return $h;
		};

		$r['ZsetPush'] = function($r){
			$r['ZsetPush']= new ZsetPushOperation(
				$r['Redis']
			);
			return $r['ZsetPush'];
		};

		$r['ZsetExists'] = function($r){
			$r['ZsetExists']= new ZsetExistsOperationStrategy(
				$r['Redis']
			);
			return $r['ZsetExists'];
		};


		$r['unidirectionalRelationshipBeforeSave']=function($r){
			return new UnidirectionalRelationshipBeforeSave($r);
		};

		$r['unidirectionalRelationshipAfterFind']=function($r){
			return new UnidirectionalRelationshipAfterFind($r);
		};

		$r['unidirectionalRelationship']=function($r){
			return new UnidirectionalRelationship($r);
		};



		$gcrepo = new GlueCodeRepository();

		return $gcrepo->getRegistry($r);
	}
}
?>
