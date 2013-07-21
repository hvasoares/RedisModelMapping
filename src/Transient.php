<?
namespace hvasoares\RedisModelMapping;
require_once 'PropertyAnnotation.php';
/** @Annotation */
class Transient implements PropertyAnnotation{
	public function isTransient(){
		return true;
	}
	public function setPropertyName($v){}
}
?>
