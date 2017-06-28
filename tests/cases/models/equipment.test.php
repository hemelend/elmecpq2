<?php
/* Equipment Test cases generated on: 2010-08-12 03:08:21 : 1281583941*/
App::import('Model', 'Equipment');

class EquipmentTestCase extends CakeTestCase {
	var $fixtures = array('app.equipment', 'app.customer', 'app.pqdata');

	function startTest() {
		$this->Equipment =& ClassRegistry::init('Equipment');
	}

	function endTest() {
		unset($this->Equipment);
		ClassRegistry::flush();
	}

}
?>