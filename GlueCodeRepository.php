<?php
namespace switch5\domain;
require_once __DIR__.'/../commom/Registry.php';
require_once 'User.php';
require_once 'Sexuality.php';
require_once 'Localization.php';
require_once 'LocalizationGroup.php';
require_once 'UserIsReadyChecker.php';
use switch5\commom\Registry;
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

		$domainListeners = $r['domainListeners'];
		$domainListeners->add(new UserIsReadyChecker());

		return $r;
	}
}
?>
