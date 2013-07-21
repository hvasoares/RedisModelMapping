<?php
namespace hvasoares\RedisModelMapping\weakEntity;
require_once __DIR__.'/../ProxyRepositoryStrategy.php';
class RepositoryStrategy
	extends \hvasoares\RedisModelMapping\ProxyRepositoryStrategy{
	private $val;
	public function __construct($innerRepo,$savingListener){
		parent::__construct($innerRepo);
		$this->saveListener = $savingListener;
	}

	public function getSchemaClosure(){
		$inSchema = $this->innerStrategy->getSchemaClosure();
		$val = $this->getValidation();

		return function($model) use($inSchema,$val){
			$inSchema($model);
			$model->setValidationClosure($val);	
		};	
	}

	public function getValidation(){
		if($this->val)
			return $this->val;
		$saveListener = $this->saveListener;
		$innerVal = parent::getValidation();
		$this->val =function($raw) use($saveListener,$innerVal){
			if($saveListener->isSaving())
				return isset($raw['id'])
				&& $raw['id'];
			return $innerVal($raw);
		};
		return $this->val;
	}
}
?>
