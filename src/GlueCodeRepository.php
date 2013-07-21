<?php
namespace hvasoares\RedisModelMapping;
require_once __DIR__.'/../commom/Registry.php';
require_once 'User.php';
require_once 'Sexuality.php';
require_once 'Localization.php';
require_once 'LocalizationGroup.php';
require_once 'UserIsReadyChecker.php';
use hvasoares\commom\Registry;
class GlueCodeRepository{
	public function getRegistry($top){
		$r = new Registry($top);

		$repoCreator =$r['repositoryCreator'];
		$repoCreator->createRepository(new Localization());
		$repoCreator->createRepository(new User());
		$repoCreator->createRepository(new Sexuality());
		$repoCreator->createRepository(
			new LocalizationGroup()
		);

		$RedisModelMappingListeners = $r['RedisModelMappingListeners'];
		$RedisModelMappingListeners->add(new UserIsReadyChecker());

		return $r;
	}
}
?>
