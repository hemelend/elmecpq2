<?php
/* Customer Fixture generated on: 2010-08-28 00:08:54 : 1282956594 */
class CustomerFixture extends CakeTestFixture {
	var $name = 'Customer';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'medidor' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'ubicacion' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'topologia' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'servicio' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'system_id' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'equipment_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'status' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'action' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'failed_reason' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'analysis_done' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'medidor' => 'Lorem ipsum dolor sit amet',
			'ubicacion' => 'Lorem ipsum dolor sit amet',
			'topologia' => 'Lorem ipsum dolor sit amet',
			'servicio' => 'Lorem ipsum dolor sit amet',
			'system_id' => 1,
			'equipment_id' => 1,
			'status' => 'Lorem ipsum dolor sit amet',
			'action' => 'Lorem ipsum dolor sit amet',
			'failed_reason' => 'Lorem ipsum dolor sit amet',
			'analysis_done' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>