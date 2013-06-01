<?php
namespace switch5\domain;
require_once 'UserIsReadyChecker.php';
use \Mockery as m;
class UserIsReadyCheckerTest extends \PHPUnit_Framework_Testcase{
	public function testUserHasSexualityAndLocalization(){
		$model = m::mock('user');
		$model->shouldReceive('sexuality')
			->andReturn("not_null_sex_val")
			->times(2);
		$model->shouldReceive('localization')
			->andReturn('not_null_loc_val')
			->times(2);
		$r = array(
			'localizationGroupRepository' => $repo = m::mock('repo')
		);

		$repo->shouldReceive('createNewModel')
			->andReturn($loc = m::mock('model'))
			->once();

		$loc->shouldReceive('sexuality')
			->with('not_null_sex_val')
			->once();
		$loc->shouldReceive('localization')
			->with('not_null_loc_val')
			->once();

		$repo->shouldReceive('save')
			->with($loc)
			->once();
		
		$loc->shouldReceive('addUser')
			->with($model);

		$inst = new UserIsReadyChecker($r);
		$inst->setRegistry($r);
		$inst->afterSave($model);

	}
}
?>
