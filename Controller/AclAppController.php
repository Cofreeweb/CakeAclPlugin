<?php
App::uses('AppController', 'Controller');

class AclAppController extends AppController 
{
  public $helpers = array(
		'Form' => array('className' => 'Management.AdminForm'),
		'Paginator' => array('className' => 'Management.AdminPaginator'),
	);
}
?>