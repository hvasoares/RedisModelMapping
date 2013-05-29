<?php
namespace switch5\domain\hashedId;
require __DIR__.'/RepositoryStrategy.php';
require 'KeyUpdater.php';
require 'Generator.php';
require 'BeforeSaveIdTunning.php';
require __DIR__.'/../ModelIncrKeyListener.php';
if(!class_exists('\switch5\commom\Registry'))
	require_once  __DIR__.'/../../commom/Registry.php';
class Builder{
	public function __construct($r){
		$this->wkb = $r['weakEntityBuilder'];
		$this->r = new \switch5\commom\Registry($r);
	}
	public function baseProperty(){
		$this->r['attrs'] = func_get_args();
		return $this;
	}
	public function get($repoBuilder){
		$g = new Generator($this->r);
		$k = new KeyUpdater($this->r);
		$s = new RepositoryStrategy(null,$this->r);
		$s->setSchemaClosureListener(new
			\switch5\domain\ModelIncrKeyListener()
		);
		$this->wkb->fromModel("hashedid")
			->toModel('hashedid')
			->get($repoBuilder);

		$repoBuilder->addListener($g);
		$repoBuilder->addListener(new BeforeSaveIdTunning(
			$this->r
		));

		$repoBuilder->addListener($k);
		$repoBuilder->strategy($s);
		return $repoBuilder;
	}	
}
?>
