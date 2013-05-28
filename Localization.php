<?php
namespace switch5\domain;
class Localization{
	private $id;
	private $name;
	private $top_location;
	private $first_user;

	public function name($val){
		return $this->name=$val;
	}
}
?>
