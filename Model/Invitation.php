<?php
App::uses('AclAppModel', 'Acl.Model');
/**
 * Invitation Model
 *
 */
class Invitation extends AclAppModel 
{
  public $actsAs = array(
      'Cofree.Saltable'
  );
  
	public $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
        'message' => 'El email no es correcto.',
        'allowEmpty' => false,
        'required' => false,
        'on' => array( 'create', 'update'), // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
