<?php
namespace hvasoares\RedisModelMapping\weakEntity;
require_once 'WeakEntityRepositoryStrategy.php';
require_once 'WeakEntityListener.php';
require_once __DIR__.'/../ExtendedRepository.php';
class Builder{
	private $fromModel;
	private $toModel;
	private $innerStrategy;

	public function fromModel($v){
		$this->fromModel =$v;
		return $this;
	}
	public function toModel($v){
		$this->toModel =$v;
		return $this;
	}
	public function strategy($v){
		$this->strategy =$v;
		return $this;
	}
	public function get($repoBuilder){
		$wkl = new BeforeSaveListener(
			$this->fromModel,
			$this->toModel
		);
		$repoBuilder->strategy(
			new RepositoryStrategy(
				null,
				$wkl
			)
		);
		$repoBuilder->addListener($wkl);
		return $repoBuilder;
	}
}
?>
