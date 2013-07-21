<?
class M implements ArrayAccess{
	public function offsetSet($index,$val){}
	public function offsetGet($index){}
	public function offsetUnset($index){
		echo "unset";
	}
	public function offsetExists($index){}
}

$m = new M;

$m[]=1;

unset($m[0]);
?>
