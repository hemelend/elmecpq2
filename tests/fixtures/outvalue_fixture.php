<?php
/* Outvalue Fixture generated on: 2010-10-16 17:10:18 : 1287249438 */
class OutvalueFixture extends CakeTestFixture {
	var $name = 'Outvalue';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'client_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'metric' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'value' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '6,3'),
		'date' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'client_id' => 1,
			'metric' => 'Lorem ipsum dolor sit amet',
			'value' => 1,
			'date' => '2010-10-16 17:17:18'
		),
	);
}
?>