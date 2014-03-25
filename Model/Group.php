<?php

App::uses('AclAppModel', 'Acl.Model');

/**
 * Group Model
 *
 * @property Group $Group
 */
class Group extends AclAppModel 
{
    public $name = 'Group';
    
    public $useTable = "groups";
    
    public $validate = array(
        'name' => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'Group name can not be empty.'),
            'unique' => array('rule' => 'isUnique','message' => 'Group name already in use.')
        )
    );
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

    function parentNode() {
        return null;
    }
    
    public function afterFind( $results)
    {
      if( isset( $results [0][$this->alias]))
      {
        foreach( $results as $key => $result)
        {
          if( !empty( $result [$this->alias]['permissions']))
          {
            $results [$key][$this->alias]['permissions'] = explode( ',', $results [$key][$this->alias]['permissions']);
          }
          else
          {
            $results [$key][$this->alias]['permissions'] =  array();
          }
        }
      }
      
      return $results;
    }
    
    public function beforeSave( $created = false)
    {
      parent::beforeSave( $created);
      
      if( isset( $this->data [$this->alias]['permissions']) && is_array( $this->data [$this->alias]['permissions']))
      {
        $this->data [$this->alias]['permissions'] = implode( ',', $this->data [$this->alias]['permissions']);
      }
      
      return true;
    }
}
