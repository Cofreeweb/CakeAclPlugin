<?php

/**
 * Users Controller
 *
 * Eventos
 *
 * Acl.Controller.Users.beforeFilter
 * Acl.Controller.Users.beforeLogin
 * Acl.Controller.Users.afterLogin
 * Acl.Controller.Users.afterAdminCreate
 * Acl.Controller.Users.beforeRegister
 * Acl.Controller.Users.afterRegister
 * Acl.Controller.Users.afterConfirmation
 * Acl.Controller.Users.adminEdit
 * Acl.Controller.Users.adminAdd
 *
 * @package acl
 */
 

App::uses('AclAppController', 'Acl.Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('AclSender', 'Acl.Lib');


class UsersController extends AclAppController 
{
    public $uses = array('Acl.User');

    public function beforeFilter() 
    {
      parent::beforeFilter();
      // App::build( array( 'View' => App::pluginPath( 'Management') .'View'. DS));
      // $this->layout = "admin";
      $this->Auth->allow( 
        'login', 
        'admin_login',
        'logout', 
        'forgot_password', 
        'admin_forgot_password',
        'register', 
        'activate_password', 
        'admin_activate_password',
        'confirm_register', 
        'confirm_email_update',
        'send_confirm'
      );

      $this->User->bindModel(array('belongsTo'=>array(
          'Group' => array(
              'className' => 'Acl.Group',
              'foreignKey' => 'group_id',
              'dependent'=>true
          )
      )), false);
      
      // BeforeFilter Event
      $event = new CakeEvent( 'Acl.Controller.Users.beforeFilter', $this);
  		$this->getEventManager()->dispatch($event);
    }
    
    /**
     * login method
     *
     * @return void
     */
    public function login() 
    {      
      // BeforeLogin Event
      $event = new CakeEvent( 'Acl.Controller.Users.beforeLogin', $this);
  		$this->getEventManager()->dispatch($event);
  		
      if( $this->request->is('post')) 
      {
        if( $this->Auth->login()) 
        {
          $this->User->id = $this->Auth->user( 'id');
          $this->User->saveField( 'last_login', date( 'Y-m-d H:i:s'));
          // AfterLogin Event
          $event = new CakeEvent( 'Acl.Controller.Users.afterLogin', $this);
      		$this->getEventManager()->dispatch($event);
      		
          $this->redirect($this->Auth->redirect());
        } 
        else 
        {
          
        }
      }
    }
    
    
    public function admin_login()
    {
      $this->layout = "login";
      
      if( $this->Auth->user())
      {
        $this->redirect('/');
      }
      
      $this->login();
    }
    
    /**
     * logout method
     *
     * @return void
     */
    public function logout() 
    {
      $this->redirect( $this->Auth->logout());
    }
    
    public function admin_logout() 
    {
      $this->redirect( $this->Auth->logout());
    }
    
  /**
   * index method
   *
   * @return void
   */
  public function admin_index() 
  {
    $this->set('title', 'Users');
    $this->set('description', 'Manage Users');

    $this->User->recursive = 1;
    $this->paginate = array(
        'limit' => 10,
        'conditions' => array(
            'Group.level >=' => $this->Auth->user( 'Group.level') 
        )
    );
    $this->set('users', $this->paginate("User"));
  }

  /**
   * admin_search method
   *
   * @return void
   */
  public function admin_search() 
  {
    if( !empty( $this->data))
    {
      $name = $this->data['User']['name'];
      $this->set('title', 'Users');
      $this->set('description', 'Manage Users');

      $this->User->recursive = 1;
      $this->paginate = array(
          'limit' => 10,
          'conditions' => array(
              'Group.level >=' => $this->Auth->user( 'Group.level'),
              'User.name ILIKE' => "%$name%"
          )
      );
      $this->set('users', $this->paginate("User"));
    }
  }
  
  
  public function admin_delete($id = null) 
	{
		$this->{$this->modelClass}->id = $id;
		
		if (!$this->{$this->modelClass}->exists()) 
		{
			throw new NotFoundException( 'Invalid content for delete');
		}

		if ($this->{$this->modelClass}->delete()) 
		{
			$this->Manager->flashSuccess( __d("admin", "El contenido ha sido borrado"));
			$this->redirect( 'index');
		} 
		else 
		{
			$this->Manager->flashError( __d( 'admin', "El contenido no ha podido borrarse"));
			$this->redirect( 'index');
		}
	}
   
  /**
   * edit method
   *
   * @param string $id
   * @return void
   */
  public function edit() 
  {
    $has_password_errors = false;
    
    $id = $this->Auth->user( 'id');
    
    if( empty( $id))
    {
      $id = $this->Auth->user( 'User.id');
    }
    
    $this->User->id = $id;
    
    $this->User->validator()->remove( 'email');
    
    if( !$this->User->exists()) 
    {
        throw new NotFoundException( 'Invalid user');
    }
    
    $this->request->data ['User']['id'] = $this->User->data ['User']['id'] = $id;

    if( $this->request->is('post') || $this->request->is('put')) 
    {
        $valid = true;
        
        if( empty( $this->request->data ['User']['password']))
        {
          $this->User->validator()->remove( 'password');
        }
        
        $password_changed = false;
        
        if( !empty( $this->request->data ['User']['password_current']))
        {
          $password = $this->Auth->password( $this->request->data ['User']['password_current']);
          
          if( $password != $this->User->field( 'password', array(
              'User.id' => $id
          )))
          {
            $this->User->invalidate( 'password_current', __( "Password is incorrect"));
            $valid = false;
          }
          else
          {
            if( !empty( $this->request->data ['User']['password']))
            {
              $password_changed = true;
            }
          }
        }

        if( $valid && $this->User->saveAll( $this->request->data)) 
        {
          $this->request->data ['Company']['user_id'] = $this->User->id;
          $this->User->Company->save( $this->request->data);
          $this->Session->renew();
          $user = $this->User->find( 'first', array(
              'conditions' => array(
                  'User.id' => $this->User->id
              ),
              'recursive' => -1
          ));
    			$this->Session->write( 'Auth.User', $user ['User']);
    			$this->_setFlash( 'Your user data has been successfully updated');
    			
    			if( $password_changed)
    			{
    			  AclSender::send( 'changePassword', $user, Settings::read( 'App.Web.title'));
    			}
    			
    			$event = new CakeEvent( 'Acl.Controller.Users.afterSaveProfile', $this);
    			$this->getEventManager()->dispatch($event);
    			
          $this->redirect( array(
              'plugin' => 'acl',
              'controller' => 'users',
              'action' => 'edit'
          ));
        } 
        else 
        {
          $data = $this->User->read(null, $id);
          $this->request->data ['User'] = array_merge( $data ['User'], $this->request->data ['User']);
          $this->Session->setFlash('The user could not be saved. Please, try again.', 'alert/error');
        }
    } 
    else 
    {
      $this->request->data = $this->User->read(null, $id);
      $this->request->data ['User']['password'] = null;
    }
    
    $this->set( compact( 'has_password_errors'));
  }
  
  
  public function change_email()
  {
    if( $this->request->is('post') || $this->request->is('put')) 
    {
      $password = $this->User->field( 'password', array(
          'User.id' => $this->Auth->user( 'id')
      ));
      
      if( $this->Auth->password( $this->request->data ['User']['password']) != $password)
      {
        $this->User->invalidate( 'password', __d( 'admin', "The password is incorrect"));
      }
      else
      {
        unset( $this->request->data ['User']['password']);
        
        if( $this->User->save( $this->request->data))
        {
          $this->_setFlash( 'Your user data has been successfully updated');
          $this->redirect(array(
              'controller' => 'users',
              'action' => 'edit'
          ));
        }
      }
    }
    else
    {
      $this->request->data = $this->User->read(null, $this->Auth->user( 'id'));
    }
  }
    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->User->id = $id;
        if( !$this->User->exists()) {
            throw new NotFoundException('Invalid user', 'alert/error');
        }
        $this->set('user', $this->User->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function admin_add() 
    {
      if( $this->request->is('post')) 
      {
        $this->User->create();
        $password = $this->request->data ['User']['password'];

        if( $this->User->save( $this->request->data)) 
        {
          // afterAdminCreate Event
          $event = new CakeEvent( 'Acl.Controller.Users.afterAdminCreate', $this);
      		$this->getEventManager()->dispatch($event);
      		
          $user = $this->User->read( null, $this->User->id);
          AclSender::send( 'add', $user, $password);
          $this->Manager->flashSuccess( __d( 'admin', 'El usuario ha sido creado correctamente'));
          $this->redirect( array( 'action' => 'index'));
        } 
        else 
        {
          $this->Manager->flashError( __d( 'admin', 'Hay errores en la creación del usuario. Por favor, revisa los campos.'));
        }
      }
      
      // adminEdit Event
      $event = new CakeEvent( 'Acl.Controller.Users.adminAdd', $this);
      $this->getEventManager()->dispatch($event);

      $this->__setAdminGroups();
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) 
    {      
      if( !$id)
      {
        $id = $this->Auth->user( 'id');
      }
      
      $user = $this->User->find( 'first', array(
          'conditions' => array(
              'User.id' => $id,
              'Group.level >=' => $this->Auth->user( 'Group.level') 
          ),
          'contain' => array(
              'Group'
          )
      ));
      
      if( !$user) 
      {
         throw new NotFoundException( 'Invalid user');
      }
      
      if( $this->request->is('post') || $this->request->is('put')) 
      {
        $valid = true;
        
        
        if( empty( $this->request->data ['User']['password']))
        {
          $this->User->validator()->remove( 'password');
        }
        
        if( !empty( $this->request->data ['User']['password_current']))
        {
          $password = $this->Auth->password( $this->request->data ['User']['password_current']);

          if( $password != $this->User->field( 'password', array(
              'User.id' => $id
          )))
          {
            $this->User->invalidate( 'password_current', __d( 'admin', "La contraseña es incorrecta"));
            $valid = false;
          }
        }
        
        if( $valid && $this->User->save($this->request->data)) 
        {
          $this->Manager->flashSuccess( __d( 'admin', 'El usuario se ha guardado correctamente'));
          $this->redirect( array(
            'action' => 'edit',
            $this->User->id
          ));
        } 
        else 
        {
          $this->Manager->flashError( __d( 'admin', 'Ha habido errores al guardar el usuario'));
        }
      } 
      else 
      {
          $this->request->data = $user;
          $this->request->data['User']['password'] = null;
      }

      $this->__setAdminGroups();

      // adminEdit Event
      $event = new CakeEvent( 'Acl.Controller.Users.adminEdit', $this);
      $this->getEventManager()->dispatch($event);
    }
    
    public function __setAdminGroups()
    {
      $groups = $this->User->Group->find('list', array(
          'conditions' => array(
              'Group.level >=' => $this->Auth->user( 'Group.level') 
          )
      ));
      $this->set( compact( 'groups'));
    }

    /**
     * delete method
     *
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if( !$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if( !$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if( $this->User->delete()) {
            $this->Session->setFlash(__('User deleted'), 'alert/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'), 'alert/error');
        $this->redirect(array('action' => 'index'));
    }

    /**
     *  Active/Inactive User
     *
     * @param <int> $user_id
     */
    public function toggle($user_id, $status) {
        $this->layout = "ajax";
        $status =( $status) ? 0 : 1;
        $this->set(compact('user_id', 'status'));
        if( $user_id) {
            $data['User'] = array('id'=>$user_id, 'status'=>$status);
            $allowed = $this->User->saveAll($data["User"], array('validate'=>false));
        }
    }

    /**
     * register method
     *
     * @return void
     */
    public function register() 
    {
      // beforeRegister Event
      $event = new CakeEvent( 'Acl.Controller.Users.beforeRegister', $this);
  		$this->getEventManager()->dispatch($event);
  		
      // Invitation
      if( isset( $this->request->query ['invitation']))
      {
        $this->loadModel( 'Acl.Invitation');
        
        $invitation = $this->Invitation->findBySalt( $this->request->query ['invitation']);
        
        if( $invitation)
        {
          $this->Session->write( 'Invitation', $invitation ['Invitation']['id']);
        }
      }
      
      
      if( $this->request->is( 'post')) 
      {
        $this->loadModel( 'Acl.User');
        $this->User->create();
        
        // Grupo por defecto
        if( Configure::read( 'Acl.defaults.group'))
        {
          $group_id = $this->User->Group->field( 'id', array(
              'Group.slug' => Configure::read( 'Acl.defaults.group')
          ));
          
          $this->request->data ['User']['group_id'] = $group_id;
        }
        
        if( Configure::read( 'Acl.defaults.status'))
        {
          $this->request->data ['User']['status'] = Configure::read( 'Acl.defaults.status');
        }
        
        $token = String::uuid();
        $this->request->data ['User']['key'] = $token; //key
        
        if( $this->User->saveAll( $this->request->data)) 
        {
          // Session de nuevo registro
          $this->Session->write( 'Acl.newRegistration', true);
          
          // AfterRegister Event
          $event = new CakeEvent( 'Acl.Controller.Users.afterRegister', $this);
      		$this->getEventManager()->dispatch($event);
      		
      		$user = $this->User->find( 'first', array(
              'conditions' => array(
                  'User.id' => $this->User->id
              ),
          ));
          
          
          // Invitation
          // Marca el id de usuario en la invitation
          if( $this->Session->read( 'Invitation'))
          {
            $this->loadModel( 'Acl.Invitation');
            
            $this->Invitation->id = $this->Session->read( 'Invitation');
            $this->Invitation->saveField( 'new_user_id', $this->User->id);
            $this->Invitation->saveField( 'salt', null);
          }
          
      		AclSender::send( 'registration', $user, Settings::read( 'App.Web.title'));
      		
          $link = Router::url( array(
              'plugin' => 'acl',
              'controller' => 'users',
              'action' => 'confirm_register',
              $this->User->id,
              $token
          ), true);
          
          if( Configure::read( 'Acl.loginAfterRegister'))
          {
            $this->Auth->login( $user);
            $this->User->saveField( 'last_login', date( 'Y-m-d H:i:s'));
            $this->redirect( Configure::read( 'Acl.redirectRegister'));
          }
          
          $this->Session->setFlash( __( '¡Gracias por registrarte! Te hemos enviado un email para verificar tu cuenta.'), 'alert/success');
          $this->request->data = null;
          $this->redirect( array( 'action' => 'login'));
        } 
        else 
        {
          $this->Session->setFlash( __( 'No ha sido posible realizar el registro correctamente. Por favor, inténtalo de nuevo.'), 'alert/error');
        }
      }
      
      $groups = $this->User->Group->find( 'list');
      $this->set( compact( 'groups'));
    }
    
    public function send_confirm()
    {
      $this->autoRender = false;
      
      $user = $this->User->find( 'first', array(
          'conditions' => array(
              'User.id' => $this->Auth->user( 'id')
          ),
      ));
      
      AclSender::send( 'registration', $user, Settings::read( 'App.Web.title'));
      
      $this->Session->setFlash( __('Se ha enviado un correo de confirmación'), 'alert/success');
      
      $this->redirect( $this->referer());
    }
    
    /**
    * confirm register
    * @return void
    */
    public function confirm_register( $ident = null, $activate = null) 
    {
      $return = $this->User->confirmRegister( $ident, $activate);
      
      if( $return) 
      {
        $this->Session->setFlash( __('¡El registro ha sido completado'), 'alert/success');
        
        if( $this->Auth->user())
        {
          $user = $this->User->find( 'first', array(
              'conditions' => array(
                  'User.id' => $ident
              )
          ));
          
          $this->Session->renew();
    			$this->Session->write( 'Auth.User', $user);
    			
    			// afterConfirmation Event
          $event = new CakeEvent( 'Acl.Controller.Users.afterConfirmation', $this);
      		$this->getEventManager()->dispatch($event);
      		
          $this->redirect( '/');
        }
        else
        {
          $this->redirect( array( 'action' => 'login'));
        }
      } 
    }
    /**
    * forgot password
    * @return void
    */
    public function forgot_password() 
    {
      if( $this->request->is('post')) 
      {
        $email = $this->request->data ["User"]["email"];
        
        if( $this->User->forgotPassword( $email)) 
        {
          $this->Session->setFlash( __( 'Por favor, revisa tu correo electrónico.'), 'alert/success');
          $this->redirect( array('action' => 'login'));
        } 
        else 
        {
          $this->Session->setFlash( __( 'El email no es válido o no está en nuestra base de datos.'), 'alert/error');
        }
      }
    }
    
    public function admin_forgot_password()
    {
      $this->layout = 'login';
      $this->forgot_password();
    }
    
    /**
    * active password
    * @return void
    */
    public function activate_password( $ident = null, $activate = null, $expiredTime) 
    {
      $nowTime = strtotime( date( 'Y-m-d H:i'));
      
      $user = $this->User->findById( $ident);
      
      $verify = false;
      
      if( $user)
      {
        $password = $user ['User']['password'];
        $salt = Configure::read("Security.salt");
        $thekey = md5($password . $salt);
        
        if( $thekey == $activate) 
        {
          $verify = true;
        }
      }

      if( !$verify || empty( $expiredTime) || $nowTime > $expiredTime)
      {
        $this->Manager->flashError( __( 'El enlace ha caducado'));
        $this->redirect( array('action' => 'login'));
      }
      
      if( $this->request->is( 'post')) 
      {
        if( !empty( $this->request->data ['User']['ident']) && !empty( $this->request->data ['User']['activate'])) 
        {
          $this->set( 'ident', $this->request->data ['User']['ident']);
          $this->set( 'activate', $this->request->data ['User']['activate']);

          $return = $this->User->activatePassword( $this->request->data);
        
          if( $return) 
          {
            $this->User->set( $this->request->data);
            
            $this->User->removeValidationRecoverPassword();
            
            if( $this->User->validates()) 
            {
              $this->request->data ['User']['id'] = $this->request->data ['User']['ident'];
              
              if($this->User->saveAll( $this->request->data ['User'], array( 'validate'=>false)))
              {
                $this->Manager->flashSuccess( __('La nueva contraseña ha sido guardada'));
                $this->redirect( array( 'action' => 'login'));
              }
            }
            else
            {
              $errors = $this->User->validationErrors;
              $this->Manager->flashError( ('Error Occur!'));
            }
          } 
          else 
          {
            $this->Manager->flashError( __( 'No ha podido guardarse la nueva contraseña. Por favor, haz click de nuevo en el enlace del email que te enviamos.'));
          }
        }
      }
      
      $this->set( compact( 'ident', 'activate'));
    }
    
    
    public function admin_activate_password( $ident=null, $activate=null, $expiredTime)
    {
      $this->layout = 'login';
      $this->activate_password( $ident, $activate, $expiredTime);
    }
    
    
    /**
     * edit profile method
     *
     * @return void
     */
    public function edit_profile() {
        if( $this->request->is('post') || $this->request->is('put')) {
            if(!empty($this->request->data['User']['password']) || !empty($this->request->data['User']['password2'])){
                //do nothing
            }else{
                //do not check password validate
                unset($this->request->data['User']['password']);
            }

            $this->User->set($this->request->data);
            if( $this->User->validates()) {
                //check email change
                if($this->request->data['User']['email'] != $this->Session->read('Auth.User.email')){
                    $this->Session->write('Auth.User.needverify_email', $this->request->data['User']['email']);
                    $id = $this->Session->read('Auth.User.id');
                    $email = base64_encode($this->request->data['User']['email']);
                    $expiredTime = strtotime(date('Y-m-d H:i', strtotime('+24 hours')));
                    $comfirm_link = Router::url("/acl/users/confirm_email_update/$id/$email/$expiredTime", true);
                    $cake_email = new CakeEmail();
                    $cake_email->from(array('no-reply@example.com' => 'Please Do Not Reply'));
                    $cake_email->to($this->request->data['User']['email']);
                    $cake_email->subject(''.__('Email Address Update'));
                    $cake_email->viewVars(array('comfirm_link'=>$comfirm_link, 'old_email'=> $this->Session->read('Auth.User.email'), 'new_email'=>$this->request->data['User']['email']));
                    $cake_email->emailFormat('html');
                    $cake_email->template('Acl.email_address_update');
                    $cake_email->send();

                    unset($this->request->data['User']['email']);
                }


                $this->request->data['User']['id'] = $this->Session->read('Auth.User.id');
                if($this->User->saveAll($this->request->data['User'], array('validate'=>false))){
                    $this->Session->setFlash(__('Congrats! Your profile has been updated successfully'), 'alert/success');
                    $this->redirect(array('action' => 'edit_profile',));
                }
            }else{
                $errors = $this->User->validationErrors;
                $this->Session->setFlash(__('Something went wrong. Please, check your information.'), 'alert/error');
            }

        }else{
            $this->request->data = $this->User->read(null, $this->Auth->user('id'));
            $this->request->data['User']['password'] = '';
        }
    }
         /**
    * confirm register
    * @return void
    */
    public function confirm_email_update($id=null, $email=null, $expiredTime=null) {
        $nowTime = strtotime(date('Y-m-d H:i'));
        if(empty($expiredTime) || $nowTime > $expiredTime){
            $this->Session->setFlash(__('Your link had been expired.'), 'alert/error');
            $this->redirect(array('action' => 'login'));
        }

        $email = base64_decode($email);
        if(Validation::email($email)){
            $checkExistId = $this->User->find('count', array('conditions'=>array('User.id' => $id)));
            $checkExistEmail = $this->User->find('count', array('conditions'=>array('User.email' => $email)));

            if( $checkExistId > 0 && $checkExistEmail <= 0) {
                $this->request->data['User']['id'] = $id;
                $this->request->data['User']['email'] = $email;
                $this->User->saveAll($this->request->data, array('validate'=>false));
                $this->Auth->logout();
                $this->Session->setFlash(__('Email updated. Now, you can login with new email.'), 'alert/success');
                $this->redirect(array('action' => 'login'));
            }
        }

        $this->Session->setFlash(__('Something went wrong. Sorry for any inconvenience.'), 'alert/error');
        $this->redirect(array('action' => 'login'));
    }
}
?>