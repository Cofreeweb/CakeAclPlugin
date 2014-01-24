<?php
/**
 * AclMgmShell
 * 
 * [Short Description]
 *
 * @package default
 * @author Alfonso Etxeberria
 * @version $Id$
 * @copyright __MyCompanyName__
 **/

class AclMgmShell extends AppShell 
{
  public $uses = array( 'Acl.User', 'Acl.Group');
  
/**
 * undocumented function
 *
 * @return void
 * @example Console/cake acl.acl_mgm add_group
 */
  public function add_group()
  {
    $data = array();
    $data ['name'] = $this->in( 'Introduce el nombre del grupo');
    
    if( empty( $data ['name']))
    {
      $this->out( 'Es necesario indicar el nombre del grupo. Bye.');
      die();
    }
    
    if( $this->Group->save( $data))
    {
      $this->out( 'Se ha creado el grupo <'. $data ['name'] .'> con id <'. $this->Group->id .'>');
    }
    else
    {
      $this->out( 'No ha sido posible guardar el grupo');
    }
  }
  
/**
 * undocumented function
 *
 * @return void
 * @example bin/cake acl.acl_mgm add_user
 */
  public function add_user()
  {
    $data = array();
    
    $groups = $this->Group->find( 'list');
    
    
    foreach( $groups as $id => $name)
    {
      $this->out( "$id. $name");
    }
    
    $data ['group_id'] = $this->in( 'Selecciona un grupo para el usuario');
    
    if( empty( $data ['group_id']) || !$this->Group->findById( $data ['group_id']))
    {
      $this->out( 'Es necesario indicar un grupo correcto. Bye.');
      die();
    }
    
    $ins = array(
        'email' => 'Email',
        'password' => 'Contraseña',
        'password2' => 'Repite la contraseña',
        'name' => 'Nombre'
    );
    
    
    foreach( $ins as $key => $value)
    {
      $data [$key] = $this->in( "Indica un $value");
      
      if( empty( $data [$key]))
      {
        $this->out( "Es necesario indicar un $value Bye.");
        die();
      }
    }
    
    $data ['status'] = 1;
    
    $this->User->create();
    
    if( $this->User->save( $data))
    {
      $this->out( 'Se ha creado el usuario <'. $data ['email'] .'> con id <'. $this->User->id .'>');
    }
    else
    {
      $this->out( 'No ha sido posible guardar el usuario');
    }
  }
  
  public static function password( $password) 
  {
		return Security::hash( $password, null, true);
	}
	
/**
 * undocumented function
 *
 * @return void
 * @example bin/cake acl.acl_mgm sync
 */
	public function sync()
	{
	  App::uses('AclExtras', 'Acl.Lib');
    $acl = new AclExtras();
    $acl->aco_sync();
	}
  
}
?>