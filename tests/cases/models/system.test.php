<?php
/* System Test cases generated on: 2010-08-28 00:08:11 : 1282956491*/
App::import('Model', 'System');

class SystemTestCase extends CakeTestCase {
	var $fixtures = array('app.system', 'app.customer', 'app.equipment', 'app.pqdata');

	function startTest() {
		$this->System =& ClassRegistry::init('System');
	}

	function endTest() {
		unset($this->System);
		ClassRegistry::flush();
	}

}
?>