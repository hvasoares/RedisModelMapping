<?
namespace switch5\domain;
require_once 'SexualityRepositoryStrategy.php';
require_once 'test/RepositoryStrategyBehaviour.php';
use \Mockery as m;
class SexualityRepositoryStrategyTest 
	extends RepositoryStrategyBehaviour{

	public function getSampleModel(){
		return new Sexuality();
	}	
	public function getAttrs(){
		return array('sex','interestedSex');
	}
	public function getRepositoryStrategy(){
		return new SexualityRepositoryStrategy();
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
