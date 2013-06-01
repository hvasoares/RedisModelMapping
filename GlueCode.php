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
require_once 'relationship/Builder.php';
require_once 'relationship/BeforeSave.php';
require_once 'relationship/AfterFind.php';
require_once 'weakEntity/Builder.php';
require_once 'hashedId/Builder.php';
require_once 'RepositoryBuilder.php';
require_once 'AnnotationDriverDoctrine.php';
require_once 'GenericRepositoryStrategy.php';
require_once 'AnnotatedPropertyConsulter.php';
require_once 'AnnotatedRepositoryBuilder.php';
require_once 'AutomatedRepositoryCreator.php';
require_once 'AnnotationsModelValidator.php';
require_once 'DomainListener.php';
require_once 'Transient.php';
use switch5\commom\Registry;
class GlueCode{
	public function getRegistry($top=null){
		$r = new Registry($top);

		$r['domainListeners'] = new DomainListener($r);
		$r['domainListener'] = $r['domainListeners']; 


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


		$r['annotationValidator'] = new AnnotationsModelValidator();

		$r['repositoryBuilder'] = function($r){
			$result = new RepositoryBuilder($r);
			$result->addListener($r['annotationValidator']);
			return $result;
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
			return new relationship\BeforeSave($r);
		};

		$r['unidirectionalRelationshipAfterFind']=function($r){
			return new relationship\AfterFind($r);
		};

		$r['relationshipBuilder']=function($r){
			return new relationship\Builder($r);
		};


		$r['annotationDriver'] = new AnnotationDriverDoctrine();
		$r['repositoryCreator'] = new AutomatedRepositoryCreator($r);
		$r['annotatedRepositoryBuilder'] = new AnnotatedRepositoryBuilder($r);
		$r['annotatedPropertyConsulter'] = new AnnotatedPropertyConsulter();
		$r['annotatedPropertyConsulter']->setAnnotationDriver($r['annotationDriver']);
		$r['genericRepositoryStrategy'] = function($r){
			return new GenericRepositoryStrategy($r);
		};

		$annotations = array(
			'hashedId/HashedId.php',
			'relationship/Relationship.php',
			'Transient.php'
		);
		foreach($annotations as $a){
			$r['annotationDriver']->registerAnnotationFile(__DIR__."/$a");
		}

		$gcrepo = new GlueCodeRepository();

		return $gcrepo->getRegistry($r);
	}
}
?>
