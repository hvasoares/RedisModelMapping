<?
namespace switch5\domain;
require_once 'SexualityRepositoryStrategy.php';
use \Mockery as m;
class SexualityRepositoryStrategyTest extends \PHPUnit_Framework_Testcase{
	public function setUp(){
		$this->inst = new SexualityRepositoryStrategy();
	}
	
	public function testShouldCreateTheASexualityObject(){
		$this->assertEquals(
			get_class($this->inst->createNewModel()),
			get_class(new Sexuality())
		);
	}

	public function testSchemaShouldMapsSexualityAttrs(){
		$model = m::mock('model');
		$fn = $this->inst->getSchemaClosure();

		$model->shouldReceive('modelName')
			->with('switch5\domain\Sexuality')
			->once();

		$model->shouldReceive('attr')
			->with('sex')
			->once();
		$model->shouldReceive('attr')
			->with("interestedSex")
			->once();
		$model->shouldReceive("setValidationClosure")
			->with($this->inst->getValidation())
			->once();
		$model->shouldReceive('incrKey')
			->with('switch5\domain\User_key')
			->once();

		$fn($model);
	}

	public function testShouldValidationTrueIfTheValueIsValid()
	{
		$val = $this->inst->getValidation();
		$this->assertTrue(
			$val(array(
				'sex' => 'man',
				'interestedSex'=>'woman'
			))
		);
	}

	/**
	 * @expectedException switch5\domain\InvalidSexException
	 */
	public function testValidationSexAnExceptionWillThrow()
	{
		$val = $this->inst->getValidation();
		$val(array('sex'=>'invalid'));

	}

	/**
	 * @expectedException switch5\domain\InvalidSexException
	 */

	public function testValidationInterestedSexAnExceptionWillThrow()
	{
		$val = $this->inst->getValidation();
		$val(array(
			'sex' => 'woman',
			'interestedSex'=>'invalid'
			)
		);

	}

}
?>
