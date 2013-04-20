<?php
namespace switch5\domain;
require_once 'Localization.php';
require_once 'LocalizationGroup.php';
require_once 'LocalizationGroupTestBed.php';
class LocalizationGroupImpl implements LocalizationGroup,LocalizationGroupTestBed{
	private $users;
	public function __construct(Localization $loc){
		$this->loc =$loc;
	}

	public function setUsers($users){
		$this->users = $users;
	}

	public function nextUser(){
		$r = $this->users[0];
		unset($this->users[0]);
		return $r;
	}

	public function addUser($user){
		$this->users[]=$user;
	}
	public function getLocal(){
		return	$this->loc;
	}
	public function getUsers(){
		return $this->users;
	}
}
?>
