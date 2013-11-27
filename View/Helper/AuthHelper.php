<?php

App::uses('Hash', 'Utility');
App::uses('CakeSession', 'Model/Datasource');

class AuthHelper extends AppHelper 
{

  public $helpers = array('Html', 'Form');
  
/**
 * The session key name where the record of the current user is stored. Default
 * key is "Auth.User". If you are using only stateless authenticators set this
 * to false to ensure session is not started.
 *
 * @var string
 */
	public static $sessionKey = 'Auth.User';

/**
 * Get the current user.
 *
 * Will prefer the static user cache over sessions. The static user
 * cache is primarily used for stateless authentication. For stateful authentication,
 * cookies + sessions will be used.
 *
 * @param string $key field to retrieve. Leave null to get entire User record
 * @return mixed User record. or null if no user is logged in.
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/authentication.html#accessing-the-logged-in-user
 */
	public static function user($key = null) {
		if (!empty(self::$_user)) {
			$user = self::$_user;
		} elseif (self::$sessionKey && CakeSession::check(self::$sessionKey)) {
			$user = CakeSession::read(self::$sessionKey);
		} else {
			return null;
		}
		if ($key === null) {
			return $user;
		}
		return Hash::get($user, $key);
	}
}