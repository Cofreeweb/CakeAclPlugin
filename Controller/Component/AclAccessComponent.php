<?php
App::uses( 'Component', 'Controller');
App::uses( 'Access', 'Management.Lib');

/**
 * AclAccessComponent
 * 
 *
 * @package acl.controller.component
 **/

class AclAccessComponent extends Component 
{

  public $components = array( 'Auth', 'Acl');


  public function initialize( Controller $Controller) 
  {
    if( !$this->Auth->user())
    {
      return;
    }
    
    $group = $this->Auth->user( 'Group');
    
    $permissions = Access::getUserPermissions( $group ['permissions']);
    
    $aro = ClassRegistry::init( 'Acl.Group')->Aro->find( 'first', array(
        'conditions' => array(
            'Aro.model' => 'Group',
            'Aro.foreign_key' => $group ['id']
        )
    ));
    
    $urls = Access::getAllUrls();
    
    foreach( $permissions as $permission)
    {
      $acos = $urls [$permission];
      
      foreach( $acos as $aco)
      {
        $this->Acl->allow( $aro ['Aro'], $aco, '*');
      }
    }
  }
}
?>