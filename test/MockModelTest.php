<?php
namespace switch5\domain;
class MockModelTest1{
	private $attr1;
	public function id(){
		return 'mockModelTest1Id';
	}
	public function attr1($v=null){
		if($v==null)
			return $this->attr1;
		$this->attr1=$v;
	}
}

class MockModelTest2{
	private $attr2;
	public function id(){
		return 'mockModelTest2Id';
	}
}
?>
