<?php
/* Equipment Test cases generated on: 2010-08-12 03:08:20 : 1281583460*/
App::import('Controller', 'Equipment');

class TestEquipmentController extends EquipmentController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class EquipmentControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.equipment', 'app.customer', 'app.pqdata');

	function startTest() {
		$this->Equipment =& new TestEquipmentController();
		$this->Equipment->constructClasses();
	}

	function endTest() {
		unset($this->Equipment);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>