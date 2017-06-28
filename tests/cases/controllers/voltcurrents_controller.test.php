<?php
/* Voltcurrents Test cases generated on: 2010-07-16 04:07:49 : 1279253509*/
App::import('Controller', 'Voltcurrents');

class TestVoltcurrentsController extends VoltcurrentsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class VoltcurrentsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.voltcurrent', 'app.customer');

	function startTest() {
		$this->Voltcurrents =& new TestVoltcurrentsController();
		$this->Voltcurrents->constructClasses();
	}

	function endTest() {
		unset($this->Voltcurrents);
		ClassRegistry::flush();
	}

}
?>