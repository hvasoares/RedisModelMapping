<?php
namespace switch5\domain;
use switch5\domain\hashedId\HashedId;
/** @HashedId(attrs={"sexuality_id","localization_id"})*/
interface LocalizationGroup{
	public $id;
	public $sexuality_id;
	public $localization_id;

	/** @Relationship(repository='userRepository',oneToMany=true)  */
	private $users;

	public function id(){
		return $this->id;
	}

	public function sexuality($sex){
		$this->sexualityId = $sex->id();
	}
	public function localization($loc){
		$this->localization_id = $loc;
	}
}
