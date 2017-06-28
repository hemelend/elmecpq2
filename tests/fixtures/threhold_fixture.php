<?php
/* Threhold Fixture generated on: 2010-10-17 01:10:52 : 1287278332 */
class ThreholdFixture extends CakeTestFixture {
	var $name = 'Threhold';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'system_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'min' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'max' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'system_id' => 1,
			'min' => 1,
			'max' => 1
		),
	);
}
?>