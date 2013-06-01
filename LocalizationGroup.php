<?php
namespace switch5\domain;
use switch5\domain\hashedId\HashedId;
use switch5\domain\relationship\Relationship;
use \Symfony\Component\Validator\Constraints as assert;
/** @HashedId(attrs={"sexuality_id","localization_id"})*/
class LocalizationGroup{
	public $id;
	/** @assert\NotNull */
	public $sexuality_id;
	/** @assert\NotNull */
	public $localization_id;

	/** @Relationship(repository="userRepository",oneToMany=true)  */
	private $users;

	public function id(){
		return $this->id;
	}

	public function addUser($u){
		$this->users[]=$u;
		echo "depois de adicionar usuario\n".
		print_r($this->users);
	}

	public function sexuality($sex){
		$this->sexuality_id = $sex->id();
	}
	public function localization($loc){
		$this->localization_id = $loc->id();
	}
}
