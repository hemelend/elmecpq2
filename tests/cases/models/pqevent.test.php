<?php
/* Pqevent Test cases generated on: 2010-08-24 03:08:48 : 1282621368*/
App::import('Model', 'Pqevent');

class PqeventTestCase extends CakeTestCase {
	var $fixtures = array('app.pqevent', 'app.customer', 'app.equipment', 'app.pqdata');

	function startTest() {
		$this->Pqevent =& ClassRegistry::init('Pqevent');
	}

	function endTest() {
		unset($this->Pqevent);
		ClassRegistry::flush();
	}

}
?>