<?php
namespace hvasoares\RedisModelMapping;
use hvasoares\commons\Registry;
use hvasoares\commons\JsonPersitentArray;
use hvasoares\arrayredispersistence;
class GlueCode{
	public function getRegistry($top=null){

		$gcrepo = new arrayredispersistence\GlueCode();
		$r = new Registry($gcrepo->getRegistry($top));


		$seed=$top['redisModelMapping_debug'] ? rand()+time() : "";
		$config = new JsonPersitentArray(
			$top['redisModelMapping_cacheDir']
			."/rmpCache$seed.lock"
		);

		$r['phplombok_cachedir'] = $top['redisModelMapping_cacheDir'];
		$r['phplombok_debug'] = $top['phplombok_debug'];

		$r['RedisModelMappingListeners'] = new DomainListener($r);

		$r['listenerChain'] = function($r){
			return new ListenerChain();
		};

		$r['RedisModelMappingListener'] = function ($r){
			$result= new ListenerChain();
			$registry = new \hvasoares\phplombok\GlueCode();
			$result->add(new PHPLombokListener(
				$registry->getRegistry($r)
			));
			$result->add($r['RedisModelMappingListeners']);
			$r['RedisModelMappingListener']	= $result;
			return $result;
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

		return $r;
	}
}
?>
