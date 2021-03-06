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
  
  protected function forgotPassword( CakeEmail $Email, $user, $webname, $link)
  {
    $Email->subject( __d( "email", "Recuperar contraseña en %s", array(
        $webname
    )));
    $Email->template( 'Acl.forgot_password', 'Acl.default')
          ->viewVars( compact( 'user', 'webname', 'link'))
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
  
  protected function registration( CakeEmail $Email, $user, $webname)
  {
    $Email->subject( __d( "email", "¡Bienvenido a %s!", array(
        $webname
    )));
        
    $link = Router::url( array(
        'plugin' => 'acl',
        'controller' => 'users',
        'action' => 'confirm_register',
        $user ['User']['id'],
        $user ['User']['key']
    ), true);
		
    $Email->template( 'Acl.registration', 'default');
    $Email->to( $user ['User']['email']);
    $Email->viewVars( compact( 'link', 'user'));
  }
  
  protected function changePassword( CakeEmail $Email, $user, $webname)
  {    
    $Email->subject( __d( "email", "Tu contraseña ha sido cambiada en %s", array(
        $webname
    )));
		$Email->template( 'Acl.change_password', 'users');
		$Email->viewVars( compact( 'user'));
    $Email->to( $user ['User']['email']);
  }
  
  protected function invitation( CakeEmail $Email, $invitation, $user, $webname)
  {    
    $Email->subject( __d( "email", "%s te ha invitado a participar en %s", array(
        $user ['name'],
        $webname
    )));
		$Email->template( 'Acl.invitation', 'users');
		$Email->viewVars( compact( 'invitation', 'user'));
    $Email->to( $invitation ['Invitation']['email']);
  }
  
  
}