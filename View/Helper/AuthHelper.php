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
	
	public function hasConfirmedEmail()
	{
	  $key = $this->user( 'key');
	  return empty( $key);
	}
	
/**
 * Comprueba si el usuario tiene permisos sobre una URL dada o sobre la actual (si $url es false)
 *
 * @param string $url 
 * @return void
 * @example $this->Auth->hasPermissions( array( 'controller' => 'entries', 'action' => 'admin_edit'))
 */
	public function hasPermissions( $url = false)
  {
    // Si ni siquiera está logueado devolvemos false
    if( !$this->user())
    {
      return false; 
    }
    
    if( !$url)
    {
      $url = array(
          'plugin' => $this->request->params ['plugin'],
          'controller' => $this->request->params ['controller'],
          'action' => $this->request->params ['action']
      );
      
      if( !empty( $this->request->params ['prefix']))
      {
        $url ['action'] = $this->request->params ['prefix'] .'_'. $this->request->params ['action'];
      }
    }

    $aro = array( 'model' => 'Group', 'foreign_key' => $this->user( 'group_id'));
    $aco = 'controllers';
    
    if( !empty( $url ['plugin']))
    {
      $aco .= '/'. Inflector::camelize( $url ['plugin']); 
    }
    
    if( !empty( $url ['controller']))
    {
      $aco .= '/'. Inflector::camelize( $url ['controller']);
    }
    
    if( !empty( $url ['action']))
    {
      $action = !empty( $url ['admin']) ? 'admin_'. $url ['action'] : $url ['action']; 
      $aco .= '/'. $action;
    }
    $permission = ClassRegistry::init( 'Permission')->check( $aro, $aco);
    return $permission;
  }
  
/**
 * Resuelve si el usuario tiene acceso a una key dada
 *
 * @param string $key 
 * @return void
 */
  public function hasAccessKey( $key)
  {
    // Si ni siquiera está logueado devolvemos false
    if( !$this->user())
    {
      return false; 
    }
    
    $permissions = $this->user( 'Group.permissions');
    
    return (!empty( $permissions) && in_array( $key, $permissions));
  }
	
	public function isEditor()
	{
	  return $this->user();
	}
}