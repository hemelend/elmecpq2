<?php
/* Voltcurrent Test cases generated on: 2010-07-14 06:07:46 : 1279087426*/
App::import('Model', 'Voltcurrent');

class VoltcurrentTestCase extends CakeTestCase {
	var $fixtures = array('app.voltcurrent', 'app.customer');

	function startTest() {
		$this->Voltcurrent =& ClassRegistry::init('Voltcurrent');
	}

	function endTest() {
		unset($this->Voltcurrent);
		ClassRegistry::flush();
	}

}
?>