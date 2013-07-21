<?
namespace hvasoares\RedisModelMapping\relationship;
require_once 'relationship/Relationship.php';
use \Mockery as m;
class RelationshipTest extends \PHPUnit_Framework_Testcase{
	public function testShouldBuildTheRelationship(){
		$inst = new Relationship();
		$inst->setPropertyName('a_name');
		$inst->repository = 'aRepo';
		$inst->oneToMany = false;

		$inst->setRegistry(array(
			'relationshipBuilder' => $builder = m::mock('builder')
		));

		$builder->shouldReceive('setOneToOne')
			->with(true)
			->once();
		$builder->shouldReceive(
			'setRelationshipAttribute'
		)->with('a_name')
		->once();

		$builder->shouldReceive(
			'setRepository'
		)->with('aRepo')
		->once();
		$this->assertEquals(
			$builder,
			$inst->getBuilder()
		);

	}
}
?>
