<?php

App::uses( 'AclAppController', 'Acl.Controller');
App::uses( 'Access', 'Management.Lib');

/**
 * Groups Controller
 *
 * @property Group $Group
 */
class GroupsController extends AclAppController 
{
  
    public function admin_index() 
    {
        $this->set('title', 'Groups');
        $this->set('description', 'Manage Groups');

        $this->Group->recursive = 0;
        $this->set('groups', $this->paginate());
        
        $this->set( '_serialize', array( 'groups'));
    }


    /**
     * add method
     *
     * @return void
     */
    public function admin_add() 
    {
        if ($this->request->is('post')) 
        {
            $this->Group->create();
            
            if ($this->Group->save($this->request->data)) 
            {
                $this->Session->setFlash('The group has been saved', 'alert/success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The group could not be saved. Please, try again.', 'alert/error');
            }
        }
    }

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
  public function admin_edit($id = null) 
  {
    $this->Group->id = $id;
    
    if( !$this->Group->exists()) 
    {
      throw new NotFoundException('Invalid group');
    }
    
    if ($this->request->is('post') || $this->request->is('put')) 
    {
      if ($this->Group->save($this->request->data)) 
      {
        $this->Session->setFlash('The group has been saved', 'alert/success');
        $this->redirect(array('action' => 'index'));
      } 
      else 
      {
        $this->Session->setFlash('The group could not be saved. Please, try again.', 'alert/error');
      }
    } 
    else 
    {
      $this->request->data = $this->Group->read( null, $id);
    }
    
    $this->set( 'permissions', Access::getAllOptions());
  }

    /**
     * delete method
     *
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) 
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Group->id = $id;
        if (!$this->Group->exists()) {
            throw new NotFoundException('Invalid group', 'alert/error');
        }
        if ($this->Group->delete()) {
            $this->Session->setFlash('Group deleted', 'alert/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Group was not deleted', 'alert/error');
        $this->redirect(array('action' => 'index'));
    }

}
?>