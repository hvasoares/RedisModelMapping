<?php
namespace hvasoares\RedisModelMapping;
require_once 'ExtendedRepositoryListener.php';
class ListenerChain implements ExtendedRepositoryListener{
	private $allListener;
	public function __construct(){
		$this->allListener = array();
	}
	public function add($listener){
		$this->allListener []= $listener;
	}	
	public function beforeFind($id){
		foreach($this->allListener as $l)
			$l->beforeFind($id);
	}
	public function afterFind($model){
		return $this->modelTransLoop($model,'afterFind');
	}
	public function beforeSave($m){
		return $this->modelTransLoop($m,'beforeSave');
	}
	public function afterSave($m){
		return $this->modelTransLoop($m,'afterSave');
	}
	public function afterCreate($m){
		return $this->modelTransLoop($m,'afterCreate');
	}
	public function deleteListener($model){
		foreach($this->allListener as $l)
			$l->deleteListener($model);
	}
	private function modelTransLoop($model,$method){
		$last = $model;
		echo "<div>inicio chain</div>";
		foreach(array_reverse($this->allListener) as $l){
			echo "<div>". (get_class($l)) ."</div>";
			$last = call_user_func(
				array($l,$method),
				$last
			);
		}
		echo "<div>fim chain</div>";
		return $last;
	}
}
?>
