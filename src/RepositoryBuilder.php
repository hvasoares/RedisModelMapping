<?
namespace hvasoares\RedisModelMapping;
require_once 'ExtendedRepository.php';
class RepositoryBuilder{
	public function __construct($registry){
		$this->chain = $registry['listenerChain'];
		$this->strategy = array();
		$this->r = $registry;
	}
	public function addListener($v){
		$this->chain->add($v);
		return $this;
	}
	public function strategy($v){
		$this->strategy[]=$v;
		return $this;
	}
	public function get(){
		$new_strategy =$this->strategy[0];
		for($i = 1; $i<sizeof($this->strategy); $i++){
			$s = $this->strategy[$i];
			if($s instanceof ProxyRepositoryStrategy){
				$s->setStrategy($new_strategy);	
				$new_strategy=$s;
				continue;
			}
			throw new Exception('Only the first strategy can be not subclasse of ProxyRepositoryStrategy');
		}
		return new ExtendedRepository(
			$this->r['Repository'],
			$new_strategy,
			$this->chain
		);
	}
}
?>
