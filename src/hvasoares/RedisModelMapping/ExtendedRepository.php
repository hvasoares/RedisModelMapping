<?php
namespace hvasoares\RedisModelMapping;
class ExtendedRepository{
	public function __construct(
		$rawRepo,
		$rawRepoStrategy,
		$listener
	){
		$rawRepo->setStrategy($rawRepoStrategy);
		$this->rawRepo = $rawRepo;
		$this->rawRepoStrategy = $rawRepoStrategy;
		$this->listener = $listener;
	}

	public function find($id){
		$this->listener->beforeFind($id);
		return $this->listener->afterFind(
			$this->rawRepo->find($id)
		);
	}
	public function save($model){
		$this->rawRepo->save(
			$this->listener->beforeSave($model)
		);
		$this->listener->afterSave($model);
	}
	public function createNewModel(){
		return $this->rawRepoStrategy->createNewModel();
	}

	public function delete($model){
		$this->listener->deleteListener($model);
	}
	public function getClassName(){
		return get_class($this->createNewModel());
	}
}

?>
