<?php
namespace switch5\domain;
class Localization{
	private $id;
	private $name;
	private $top_location;
	private $first_user;
	private $top_location_id;
	public function __construct(){
		$top_location_id = 'default_value';
	}
	public function id(){
		return $this->id;
	}

	public function name($val=null){
		if($val)
			return $this->name=$val;
		return $this->name;
	}

	public function topLocation($v){
		$this->top_location = $v;
		if($v)
			$this->top_location_id = $v->id();
	}
}
?>
