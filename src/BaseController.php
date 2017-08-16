<?php

namespace FredBradley\CranleighCulturePlugin;

use Puc_v4_Factory;

abstract class BaseController {
	const PLUGIN_PATH = "path";

	abstract public function setupPlugin();

	public function __construct() {
		$this->setupPlugin();
	}

	public function runUpdateChecker(string $plugin_name) {
		return $this->update_check($plugin_name, "cranleighschool");
	}

	private function update_check(string $plugin_name, string $user) {

		$updateChecker = Puc_v4_Factory::buildUpdateChecker(
			'https://github.com/'.$user.'/'.$plugin_name.'/',
			dirname(dirname(__FILE__)) . '/'.$plugin_name.'.php',
			$plugin_name
		);

		/* Add in option form for setting auth token*/
		//$updateChecker->setAuthentication(GITHUB_AUTH_TOKEN);

		$updateChecker->setBranch('master');
	}

}
