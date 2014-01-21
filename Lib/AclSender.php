<?php

App::uses('EmailSender', 'Cofree.Lib');

class AclSender extends EmailSender
{
  
  protected function add( CakeEmail $Email, $user, $password)
  {
    $Email->subject( __d( 'admin', "%s te ha añadido como administrador", array(
        Configure::read( 'Config.sitename')
    )));
    $Email->template( 'Acl.add', 'Acl.default')
          ->viewVars( compact( 'user', 'password'))
          ->to( $user ['User']['email']);
  }
  
  protected function adminForgotPassword( CakeEmail $Email, $user, $webname, $link)
  {
    $Email->subject( __d( 'admin', "Recuperar contraseña en %s", array(
        $webname
    )));
    $Email->template( 'Acl.admin_forgot_password', 'Acl.default')
          ->viewVars( compact( 'user', 'webname', 'link'))
          ->to( $user ['User']['email']);
  }
  
  protected function registration( CakeEmail $Email, $user)
  {
    $Email->subject( __( "¡Welcome to Ebident!"));
        
    $link = Router::url( array(
        'plugin' => 'acl',
        'controller' => 'users',
        'action' => 'confirm_register',
        $user ['User']['id'],
        $user ['User']['key']
    ), true);
		
		$Email->viewVars( compact( 'link'));
		
    $Email->template( 'Users/registration', 'default');
    $Email->to( $user ['User']['email']);
    $Email->viewVars( compact( 'user'));
  }
  
  
}