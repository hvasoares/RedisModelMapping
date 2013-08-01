<?php
namespace hvasoares\RedisModelMapping\hashedId;
require_once __DIR__.'/../RepositoryBuilderAnnotation.php';
/** @Annotation */
class HashedId implements \hvasoares\RedisModelMapping\RepositoryBuilderAnnotation{
	/**
	 * @Required
	 * @var array<string>
	 */
	public $attrs;

	public function setRegistry($v){
		$this->r = $v;
	}	
	public function getBuilder(){
		$r = $this->r['hashedIdBuilder'];
		call_user_func_array(
			array($r,'baseProperty'),
			$this->attrs
		);
		return $r;	
	}

}
?>
