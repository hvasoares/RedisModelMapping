<?php
namespace switch5\domain;
class LocalizationGroupFactory{
	public function __construct($reg){
		$this->r=$reg;
	}
	public function create($id){
		$local = $this->r['LocalizationRepository']
			->find($id);	
		$set = $this->r['OrderedSet'];
		$set->setReferencedModel($local);
		$set->setRepository($this->r['UserRepository']);
		$localGroup = new LocalizationGroupImpl($local);
		$localGroup->setUsers($set);
		return $localGroup;
	}	
}
?>
