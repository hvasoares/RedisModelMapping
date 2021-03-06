<?php
namespace hvasoares\RedisModelMapping;
require_once '../modelmapping/GlueCode.php';
use hvasoares\modelmapping as mm;
use hvasoares\commom\Registry;
require 'GlueCode.php';

$mmgc = new mm\GlueCode();
$topr = new Registry();
$topr['Redis'] = new \redis();
$topr['Redis']->connect('127.0.0.1');
$mmregistry = $mmgc->getRegistry($topr);
$topr['sha1_salt']='mmmmmm';
$gc= new GlueCode();
$r = $gc->getRegistry($mmregistry);

class Model1{
	private $id;
	private $attr1;
	public function id(){
		return time();
	}
}

class Model2{
	private $id;
	private $attr2;
	public function id(){
		$this->attr2 = 'mmm';
		return $this->id;
	}
}

class Model2StrategyExtRepo{
	public function __construct($repo){
		$this->r = $repo;
		$this->r->setStrategy($this);
	}
	public function find($id){
		return $this->r->find($id);
	}
	public function save($model){
		return $this->r->save($model);
	}
	public function getClassName(){
		return get_class($this->createNewModel());
	}
	public function createNewModel(){
		return new Model2();
	}

	public function getSchemaClosure(){
		$val = function($raw){
			return true;
		};
		return function($m) use($val){
			$m->modelName('Model');
			$m->attr('attr2');
				$m->incrKey('modelIncr');
				$m->setValidationClosure($val);
		};
	}
}

$model1 = new Model1();

$model2Repository = new Model2StrategyExtRepo($r['Repository']);

$orderSet = $r['OrderedSet'];

$orderSet->setReferencedModel($model1);
$orderSet->setRepository($model2Repository);

$model2 = new Model2();
$model2Repository->save($model2);

$orderSet[]=$model2;

echo $orderSet[0]->id() == $model2->id();

$uRepo = $r['userRepository'];

$new_user = $uRepo->createNewModel();
$uRepo->save($new_user);

$sexualityRepo = $r['sexualityRepository'];
$new_sex = $sexualityRepo->createNewModel();

$new_sex->sex('woman');
$new_sex->interestedSex('woman');

$sexualityRepo->save($new_sex);
echo "id=". $new_sex->id() . "\n";
$new_sex = $sexualityRepo->find($new_sex->id());
echo $new_sex->sex();
echo $new_sex->interestedSex();

$localRepo = $r['localizationRepository'];

?>
