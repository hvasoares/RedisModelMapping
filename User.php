<?
namespace switch5\domain;
class User{
	public function __construct(){
		$this->created_time = time();
		$this->modified_time = time();
	}
	private $id;
	private $created_time;
	private $modified_time;
	
	public function id($val=null){
		return is_null($val) ? $this->id : $this->id=$val;
	}
	public function created_time($val=null){
		return is_null($val) ? $this->created_time : $this->created_time=$val;
	}
	public function modified_time($val=null){
		return is_null($val) ? $this->modified_time : $this->modified_time=$val;
	}
}
?>
