<?php
/* Equipment Fixture generated on: 2010-08-12 03:08:20 : 1281583940 */
class EquipmentFixture extends CakeTestFixture {
	var $name = 'Equipment';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'mark' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'serialnumber' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'mark' => 'Lorem ipsum dolor sit amet',
			'model' => 'Lorem ipsum dolor sit amet',
			'serialnumber' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>