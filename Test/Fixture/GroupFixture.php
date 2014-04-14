<?php
/**
 * GroupFixture
 *
 */
class GroupFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'level' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'slug' => 'Lorem ipsum dolor sit amet',
			'level' => 1,
			'created' => '2014-04-14 09:23:37',
			'modified' => '2014-04-14 09:23:37'
		),
		array(
			'id' => 2,
			'name' => 'Lorem ipsum dolor sit amet',
			'slug' => 'Lorem ipsum dolor sit amet',
			'level' => 2,
			'created' => '2014-04-14 09:23:37',
			'modified' => '2014-04-14 09:23:37'
		),
		array(
			'id' => 3,
			'name' => 'Lorem ipsum dolor sit amet',
			'slug' => 'Lorem ipsum dolor sit amet',
			'level' => 3,
			'created' => '2014-04-14 09:23:37',
			'modified' => '2014-04-14 09:23:37'
		),
		array(
			'id' => 4,
			'name' => 'Lorem ipsum dolor sit amet',
			'slug' => 'Lorem ipsum dolor sit amet',
			'level' => 4,
			'created' => '2014-04-14 09:23:37',
			'modified' => '2014-04-14 09:23:37'
		),
		array(
			'id' => 5,
			'name' => 'Lorem ipsum dolor sit amet',
			'slug' => 'Lorem ipsum dolor sit amet',
			'level' => 5,
			'created' => '2014-04-14 09:23:37',
			'modified' => '2014-04-14 09:23:37'
		),
		array(
			'id' => 6,
			'name' => 'Lorem ipsum dolor sit amet',
			'slug' => 'Lorem ipsum dolor sit amet',
			'level' => 6,
			'created' => '2014-04-14 09:23:37',
			'modified' => '2014-04-14 09:23:37'
		),
		array(
			'id' => 7,
			'name' => 'Lorem ipsum dolor sit amet',
			'slug' => 'Lorem ipsum dolor sit amet',
			'level' => 7,
			'created' => '2014-04-14 09:23:37',
			'modified' => '2014-04-14 09:23:37'
		),
		array(
			'id' => 8,
			'name' => 'Lorem ipsum dolor sit amet',
			'slug' => 'Lorem ipsum dolor sit amet',
			'level' => 8,
			'created' => '2014-04-14 09:23:37',
			'modified' => '2014-04-14 09:23:37'
		),
		array(
			'id' => 9,
			'name' => 'Lorem ipsum dolor sit amet',
			'slug' => 'Lorem ipsum dolor sit amet',
			'level' => 9,
			'created' => '2014-04-14 09:23:37',
			'modified' => '2014-04-14 09:23:37'
		),
		array(
			'id' => 10,
			'name' => 'Lorem ipsum dolor sit amet',
			'slug' => 'Lorem ipsum dolor sit amet',
			'level' => 10,
			'created' => '2014-04-14 09:23:37',
			'modified' => '2014-04-14 09:23:37'
		),
	);

}
