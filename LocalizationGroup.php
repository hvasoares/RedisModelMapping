<?php
namespace switch5\domain;
interface LocalizationGroup{
	public function setUsers($users);
	public function nextUser();
	public function addUser($user);
}
