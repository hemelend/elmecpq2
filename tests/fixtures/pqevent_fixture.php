<?php
/* Pqevent Fixture generated on: 2010-08-24 03:08:48 : 1282621368 */
class PqeventFixture extends CakeTestFixture {
	var $name = 'Pqevent';

	var $fields = array(
		'customer_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'datetime' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'cycle' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '6,3'),
		'type' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10),
		'phase' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 4),
		'duration' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '6,3'),
		'volttrigger' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '6,3'),
		'vrms' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '6,3'),
		'vavg' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '6,3'),
		'irms' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '6,3'),
		'iavg' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '6,3'),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'customer_id' => 1,
			'datetime' => '2010-08-24 03:42:48',
			'cycle' => 1,
			'type' => 'Lorem ip',
			'phase' => 1,
			'duration' => 1,
			'volttrigger' => 1,
			'vrms' => 1,
			'vavg' => 1,
			'irms' => 1,
			'iavg' => 1
		),
	);
}
?>