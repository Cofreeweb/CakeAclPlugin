<?php
/**
 * User Model
 */
App::uses('AclAppModel', 'Acl.Model');
App::uses('CakeEmail', 'Network/Email');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class User extends AclAppModel 
{
    public $name = 'User';
    public $useTable = "users";
    public $actsAs = array(
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
	
    function parentNode() {
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

    public function beforeSave() {
        App::uses('Security', 'Utility');
        App::uses('String', 'Utility');

        if( empty($this->data['User']['password'])) { # empty password -> do not update
            unset($this->data['User']['password']);
        } else {
            $passwordHasher = new SimplePasswordHasher();
            $this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
        }

        $this->data['User']['key'] = String::uuid();

        return true;
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

    function forgotPassword( $email) 
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

        AclSender::send( 'adminForgotPassword', $user, Configure::read( 'Config.siteName'), $link);
        return true;
      }
      else 
      {
        return false;
      }
    }
    
    function confirmRegister($id, $token) {
        $user = $this->find('count', array('conditions'=>array('User.id' => $id, 'User.token' => $token)));
        if( $user) {
           $this->saveAll(array('User'=>array('id'=>$id, 'status'=>1, 'token'=>'')), array('validate'=>false));
           return true;
        } 
        return false;
    }    

    function activatePassword($data) {
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
}