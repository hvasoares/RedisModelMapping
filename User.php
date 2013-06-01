<?
namespace switch5\domain;
use \switch5\domain\relationship\Relationship;
class User{
	public function __construct(){
		$this->created_time = time();
		$this->modified_time = time();
	}
	private $id;
	private $created_time;
	private $modified_time;

	/** @Relationship(repository="sexualityRepository") */
	private $sexuality;
	/** @Relationship(repository="localizationRepository") */
	private $localization;
	
	public function id($val=null){
		return is_null($val) ? $this->id : $this->id=$val;
	}
	public function created_time($val=null){
		return is_null($val) ? $this->created_time : $this->created_time=$val;
	}
	public function modified_time($val=null){
		return is_null($val) ? $this->modified_time : $this->modified_time=$val;
	}

	public function sexuality($val=null){
		return is_null($val) ? $this->sexuality : $this->sexuality=$val;
	}
	public function localization($val=null){
		return is_null($val) ? $this->localization : $this->localization=$val;
	}

}
?>
