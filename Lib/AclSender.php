<?php

App::uses('EmailSender', 'Cofree.Lib');

class AclSender extends EmailSender
{
  
  protected function add( CakeEmail $Email, $user, $password)
  {
    $Email->subject( __d( 'admin', "%s te ha añadido como administrador", array(
        Configure::read( 'Management.webname')
    )));
    $Email->template( 'Acl.add', 'Acl.default')
          ->viewVars( compact( 'user', 'password'))
          ->to( $user ['User']['email']);
  }
}

AclSender::configure( array(
    'class' => 'AclSender'
));