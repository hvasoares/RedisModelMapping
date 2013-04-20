<?
namespace switch5php\domain;
class User{
	private $id;
	private $sex;
	private $sexualOrientation;

	public function sex($val=null){
		return is_null($val) ? $this->sex : $this->sex = $val; 
	}

	public function sexualOrientation($val=null){
		return isnull($vall) ? $this->sexualOrientation : $this->sexualOrientation = $val;
	}
}
?>
