<?php
class FullLocalization{
	private $state;
	private $country;

	public function __construct($city){
		$this->city = $city;
	}

	public function state($v=null){
		return $this->state =$v;
	}

	public function setCountry($v=null){
		return $this->country = $v;
	}
	
}
?>
