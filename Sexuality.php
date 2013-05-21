<?
namespace switch5\domain;
class Sexuality{
	private $id;
	private $sex;
	private $interestedSex;

	public function id($val=null){
		return is_null($val) ? $this->id : $this->id=$val;
	}
	public function sex($val=null){
		return is_null($val) ? $this->sex : $this->sex = $val; 
	}

	public function interestedSex($val=null){
		return is_null($val) ? $this->interestedSex : $this->interestedSex = $val;
	}
}
?>
