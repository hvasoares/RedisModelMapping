<?php
namespace switch5\domain;
use \switch5\domain\hashedId\HashedId;
use \switch5\domain\relationship\Relationship;
use \switch5\domain\Transient;
/** @HashedId(attrs={"name","top_location_id"}) 
 *  @Target=({"CLASS"})
 */
class Localization{
	private $id;
	private $name;
	/** @Relationship(repository="localizationRepository") */
	private $top_location;
	/** @Relationship(repository="userRepository") */
	private $first_user;

	/** @Transient */
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
