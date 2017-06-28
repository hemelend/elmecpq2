<?php
/* Outvalue Test cases generated on: 2010-10-16 17:10:27 : 1287249507*/
App::import('Model', 'Outvalue');

class OutvalueTestCase extends CakeTestCase {
	var $fixtures = array('app.outvalue', 'app.customer', 'app.system', 'app.equipment', 'app.pqdata', 'app.pqevent');

	function startTest() {
		$this->Outvalue =& ClassRegistry::init('Outvalue');
	}

	function endTest() {
		unset($this->Outvalue);
		ClassRegistry::flush();
	}

}
?>