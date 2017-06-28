<?php
/* Loadprofile Fixture generated on: 2010-09-11 19:09:57 : 1284234237 */
class LoadprofileFixture extends CakeTestFixture {
	var $name = 'Loadprofile';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'customer_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'equipment_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'date' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'interval' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'KWh' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'KVAh' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'customer_id' => 1,
			'equipment_id' => 1,
			'date' => '2010-09-11 19:43:57',
			'interval' => 1,
			'KWh' => 1,
			'KVAh' => 1
		),
	);
}
?>