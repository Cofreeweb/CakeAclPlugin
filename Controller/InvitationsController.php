<?php
App::uses('AclAppController', 'Acl.Controller');
App::uses('AclSender', 'Acl.Lib');

/**
 * Invitations Controller
 *
 * Eventos
 *
 * Acl.Controller.Invitations.afterInvite
 *
 * @package acl
 */
class InvitationsController extends AclAppController 
{
  public $uses = array( 'Acl.Invitation');
  
  public function add()
  {
    if( $this->request->is('post') || $this->request->is('put')) 
    {
      $this->request->data ['Invitation']['user_id'] = $this->Auth->user( 'id');
      
      if( $this->Invitation->save( $this->request->data))
      {
        // AfterRegister Event
        $event = new CakeEvent( 'Acl.Controller.Invitations.afterInvite', $this);
    		$this->getEventManager()->dispatch($event);
    		
    		$invitation = $this->Invitation->find( 'first', array(
            'conditions' => array(
                'Invitation.id' => $this->Invitation->id
            ),
        ));
        
    		AclSender::send( 'invitation', $invitation, $this->Auth->user(), Settings::read( 'App.Web.title'));
    		
        $this->redirect( array(
            'action' => 'success',
        ));
      }
    }
  }
  
  public function success()
  {
    
  }

}
