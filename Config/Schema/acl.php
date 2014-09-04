<?
class AclSchema extends CakeSchema {
  
/**
 * Se puede definir Configure::read( 'Acl.schema.{table}') para modificar el esquema de la tabla users como la de groups 
 *
 * @param array $options 
 */
  public function __construct( $options = array())
  {
    $tables = array(
        'users',
        'groups'
    );
    
    foreach( $tables as $table)
    {
      if( Configure::read( 'Acl.schema.'. $table))
      {
        $schema = Configure::read( 'Acl.schema.'. $table);
        $this->$table = array_merge_recursive( $this->$table, $schema);

        if( isset( $this->{$table}['indexes']))
        {
          $indexes = $this->{$table}['indexes'];
          unset( $this->{$table}['indexes']);
          $this->{$table}['indexes'] = $indexes;
        }
      }
    }
    
    parent::__construct( $options);
    
  }
  
  public function before($event = array()) 
  {        
    return true;
  }

  public function after($event = array()) {
  }
  
  public $acos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'model' => array('type' => 'string', 'null' => true),
		'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'alias' => array('type' => 'string', 'null' => true),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	public $aros = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'model' => array('type' => 'string', 'null' => true),
		'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'alias' => array('type' => 'string', 'null' => true),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	public $aros_acos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'aro_id' => array('type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
		'aco_id' => array('type' => 'integer', 'null' => false, 'length' => 10),
		'_create' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'_read' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'_update' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'_delete' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'ARO_ACO_KEY' => array('column' => array('aro_id', 'aco_id'), 'unique' => 1))
	);
	
  public $users = array(
    'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
    'group_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
    'username' => array('type' => 'string', 'null' => true),
    'name' => array('type' => 'string', 'null' => true),
    'slug' => array('type' => 'string', 'null' => true),
    'password' => array('type' => 'string', 'null' => true, 'default' => null),
    'password2' => array('type' => 'string', 'null' => true, 'default' => null),
    'email' => array('type' => 'string', 'null' => true, 'default' => null),
    'avatar' => array('type' => 'string', 'null' => true, 'default' => null),
    'language' => array('type' => 'string', 'null' => true, 'default' => null),
    'timezone' => array('type' => 'string', 'null' => true, 'default' => null),
    'key' => array('type' => 'string', 'null' => true, 'default' => null),
    'status' => array('type' => 'boolean', 'null' => true, 'default' => null),
    'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
    'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
    'last_login' => array('type' => 'datetime', 'null' => true, 'default' => null),
    'indexes' => array(
      'PRIMARY' => array('column' => 'id', 'unique' => 1),
      'group_id' => array('column' => 'group_id'),
    )
  );
  
  public $groups = array(
    'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
    'name' => array('type' => 'string', 'null' => true),
    'slug' => array('type' => 'string', 'null' => true),
    'level' => array('type' => 'integer', 'null' => true, 'default' => null),
    'permissions' => array('type' => 'string', 'null' => true),
    'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
    'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
    'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
  );
  
  public $invitations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'new_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index'),
		'body' => array('type' => 'text', 'null' => false, 'default' => null),
		'salt' => array('type' => 'string', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'new_user_id' => array('column' => 'new_user_id', 'unique' => 0),
			'email' => array('column' => 'email', 'unique' => 0),
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);
  
}