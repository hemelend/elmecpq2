<?php
/* Loadprofile Test cases generated on: 2010-09-11 19:09:58 : 1284234238*/
App::import('Model', 'Loadprofile');

class LoadprofileTestCase extends CakeTestCase {
	var $fixtures = array('app.loadprofile', 'app.customer', 'app.system', 'app.equipment', 'app.pqdata', 'app.pqevent');

	function startTest() {
		$this->Loadprofile =& ClassRegistry::init('Loadprofile');
	}

	function endTest() {
		unset($this->Loadprofile);
		ClassRegistry::flush();
	}

}
?>