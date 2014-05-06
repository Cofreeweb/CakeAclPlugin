<?php
App::uses('Invitation', 'Acl.Model');

/**
 * Invitation Test Case
 *
 */
class InvitationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.acl.invitation',
		'plugin.acl.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Invitation = ClassRegistry::init('Acl.Invitation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Invitation);

		parent::tearDown();
	}

}
