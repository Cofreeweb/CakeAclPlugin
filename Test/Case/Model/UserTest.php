<?php
App::uses('User', 'Acl.Model');

/**
 * User Test Case
 *
 */
class UserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.acl.user',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->User = ClassRegistry::init('Acl.User');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->User);

		parent::tearDown();
	}

/**
 * testParentNode method
 *
 * @return void
 */
	public function testParentNode() {
	}

/**
 * testBindNode method
 *
 * @return void
 */
	public function testBindNode() {
	}

/**
 * testComparePwd method
 *
 * @return void
 */
	public function testComparePwd() {
	}

/**
 * testForgotPassword method
 *
 * @return void
 */
	public function testForgotPassword() {
	}

/**
 * testConfirmRegister method
 *
 * @return void
 */
	public function testConfirmRegister() {
	}

/**
 * testActivatePassword method
 *
 * @return void
 */
	public function testActivatePassword() {
	}
  
  
  public function testRemoveValidationRecoverPassword()
  {
    $this->User->removeValidationRecoverPassword();
    _d( $this->User->validate);
    
  }
}
