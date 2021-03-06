<?php

/**
 * User Model
 *
 * Eventos
 *
 * Acl.Model.User.construct
 * 
 *
 * @package acl
 */
 
App::uses('AclAppModel', 'Acl.Model');
App::uses('CakeEmail', 'Network/Email');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class User extends AclAppModel 
{
    public $name = 'User';
    public $useTable = "users";
    public $actsAs = array(
        'Containable',
        'Acl' => array(
            'type' => 'requester'
        ),
        'Cofree.Sluggable' => array(
        		'fields' => array(
        		    'name',
        		),
        ),
    );
    
    
    public $validate = array(
        'name' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => 'notEmpty',
            'message' => 'Es necesario introducir un nombre'
        ),
        'email' => array(
            'email' => array(
                'required' => true,
                'allowEmpty' => false,
                'rule' => 'email',
                'message' => 'El email no es correcto.',
                'last' => true
            ),
            'unique' => array(
                'required' => true,
                'allowEmpty' => false,
                'rule' => 'isUnique',
                'message' => 'El email ya está en uso por otro usuario.'
            )
        ),
        'password' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'La contraseña no puede estar vacía'
            ),
            'comparePwd' => array(
                'required' => false,
                'allowEmpty' => false,
                'rule' => 'comparePwd',
                'message' => 'La contraseña no ha sido repetida correctamente.'
            )
        )
    );
    
    
    public function __construct( $id = false, $table = null, $ds = null)
    {      
  		parent::__construct( $id, $table, $ds);
      
      // BeforeFilter Event
      $event = new CakeEvent( 'Acl.Model.User.construct', $this);
  		$this->getEventManager()->dispatch($event);
    }
	
    public function parentNode() {
        if( !$this->id && empty($this->data)) {
            return null;
        }
        if( isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        if( !$groupId) {
            return null;
        } else {
            return array('Group' => array('id' => $groupId));
        }
    }
    /**
     * Group-only ACL
     * This method will tell ACL to skip checking User Aro’s and to check only Group Aro’s.
     * Every user has to have assigned group_id for this to work.
     *
     * @param <type> $user
     * @return array
     */
    function bindNode($user) {
        return array('model' => 'Group', 'foreign_key' => $user['User']['group_id']);
    }

/*    public function beforeValidate() {
        if( isset($this->data['User']['id'])) {
            $this->validate['password']['allowEmpty'] = true;
        }

        return true;
    }*/

    public function beforeSave( $options = array()) 
    {
        App::uses('Security', 'Utility');
        App::uses('String', 'Utility');

        if( empty($this->data['User']['password'])) { # empty password -> do not update
            unset($this->data['User']['password']);
        } else {
            $passwordHasher = new SimplePasswordHasher();
            $this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
        }
        
        if( empty($this->data['User']['password2'])) { # empty password -> do not update
            unset($this->data['User']['password2']);
        } else {
            $passwordHasher = new SimplePasswordHasher();
            $this->data['User']['password2'] = $passwordHasher->hash($this->data['User']['password2']);
        }

        if( empty( $this->id))
        {
          $this->data['User']['key'] = String::uuid();
        }

        return true;
    }  
    
    
    public function afterSave( $created, $options = array())
    {
      parent::afterSave( $created);
      
      // AfterSave Event
      $event = new CakeEvent( 'Acl.Model.User.afterSave', $this);
  		$this->getEventManager()->dispatch($event);
    }
    
    
    public function comparePwd($check) 
    {
      $check['password'] = trim($check['password']);

      if( !isset($this->data['User']['id']) && strlen($check['password']) < 6) {
          return false;
      }

      if( isset($this->data['User']['id']) && empty($check['password'])) {
          return true;
      }

      $r =( $check['password'] == $this->data['User']['password2'] && strlen($check['password']) >= 6);

      if( !$r) {
          $this->invalidate( 'password2', __d( 'user', 'Password missmatch.'));
      }

      return $r;
    }

    public function forgotPassword( $email) 
    {
      $user = $this->find( 'first', array(
          "conditions" => array(
              "User.email" => $email
          )
      ));
      
      if( $user) 
      {
        $id = $user['User']['id'];

        $salt = Configure::read( "Security.salt");
        $activate_key = md5( $user['User']['password'] . $salt);
        $expiredTime = strtotime( date( 'Y-m-d H:i', strtotime( '+24 hours')));

        $link = Router::url( array(
            'plugin' => 'acl',
            'controller' => 'users',
            'action' => 'activate_password',
            $id,
            $activate_key,
            $expiredTime
        ), true);
        
        $params = Router::getParams(); ;
        $email_view = isset( $params ['admin']) ? 'adminForgotPassword' : 'forgotPassword';
        AclSender::send( $email_view, $user, Settings::read( 'App.Web.title'), $link);
        return true;
      }
      else 
      {
        return false;
      }
    }
    
    
    public function confirmRegister($id, $token) 
    {
      $user = $this->find( 'count', array(
          'conditions' => array(
              'User.id' => $id, 
              'User.key' => $token
          )
      ));

      if( $user) 
      {
        $this->id = $id;
        $this->saveField( 'status', 1);
        $this->saveField( 'key', null);
        return true;
      } 
      return false;
    }    

    public function activatePassword($data) {
        $user = $this->read(null, $data['User']['ident']);
        if( $user) {
            $password = $user['User']['password'];
            $salt = Configure::read("Security.salt");
            $thekey = md5($password . $salt);
            
            if( $thekey == $data['User']['activate']) {
                return true;               
            } else {
                return false;
            }
        } 
        return false;
    }
    
/**
 * Quita toda las validaciones excepto la de la contraseña
 *
 * @return void
 */
    public function removeValidationRecoverPassword()
    {
      foreach( $this->validate as $key => $rules)
      {
        if( strpos( $key, 'password') === false)
        {
          $this->validator()->remove( $key);
        }
      }
    }
}