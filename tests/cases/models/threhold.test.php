<?php
/* Threhold Test cases generated on: 2010-10-17 01:10:52 : 1287278332*/
App::import('Model', 'Threhold');

class ThreholdTestCase extends CakeTestCase {
	var $fixtures = array('app.threhold', 'app.system', 'app.customer', 'app.equipment', 'app.pqdata', 'app.pqevent');

	function startTest() {
		$this->Threhold =& ClassRegistry::init('Threhold');
	}

	function endTest() {
		unset($this->Threhold);
		ClassRegistry::flush();
	}

}
?>