<?
namespace switch5\domain;
use switch5\domain\hashedId\HashedId;
use \Symfony\Component\Validator\Constraints as assert;
/** @HashedId(attrs={"sex","interestedSex"}) */
class Sexuality{
	private $id;
	/** @assert\Choice(choices={"man","woman"}) */
	private $sex;
	/** @assert\Choice(choices={"man","woman"}) */
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
