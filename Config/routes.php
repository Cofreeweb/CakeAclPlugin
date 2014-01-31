<?php
//list user
Router::connect('/admin/users', array('plugin' => 'acl', 'controller' => 'users', 'action'=>'index'));

Router::connect('/admin/users/login', array('admin'=>true, 'plugin' => 'acl', 'controller' => 'users', 'action' => 'login'));
//logout
Router::connect('/admin/users/logout', array('admin'=>true, 'plugin' => 'acl', 'controller' => 'users', 'action' => 'logout'));
//user action
Router::connect('/admin/users/add', array('plugin' => 'acl', 'controller' => 'users', 'action'=>'add'));
Router::connect('/admin/users/view/*', array('plugin' => 'acl', 'controller' => 'users', 'action'=>'view'));
Router::connect('/admin/users/edit/*', array('plugin' => 'acl', 'controller' => 'users', 'action'=>'edit'));
Router::connect('/admin/users/delete/*', array('plugin' => 'acl', 'controller' => 'users', 'action'=>'delete'));
Router::connect('/admin/users/toggle/*', array('plugin' => 'acl', 'controller' => 'users', 'action'=>'toggle'));

//list group
Router::connect('/admin/groups', array('plugin' => 'acl', 'controller' => 'groups', 'action'=>'index'));
//groups action
Router::connect('/admin/groups/add', array('plugin' => 'acl', 'controller' => 'groups', 'action'=>'add'));
Router::connect('/admin/groups/edit/*', array('plugin' => 'acl', 'controller' => 'groups', 'action'=>'edit'));
Router::connect('/admin/groups/delete/*', array('plugin' => 'acl', 'controller' => 'groups', 'action'=>'delete'));

//list permissions
Router::connect('/admin/user_permissions', array('plugin' => 'acl', 'controller' => 'user_permissions', 'action'=>'index'));

$plugins = CakePlugin::loaded();

if( in_array( 'I18n', $plugins))
{
  $params = array('routeClass' => 'I18nRoute');
}
else
{
  $params = array();
}

Router::connect('/users/logout', array('plugin' => 'acl', 'controller' => 'users', 'action' => 'logout'), $params);
Router::connect('/users/register', array('plugin' => 'acl', 'controller' => 'users', 'action' => 'register'));
Router::connect('/users/confirm_register', array('plugin' => 'acl', 'controller' => 'users', 'action' => 'confirm_register'), $params);
Router::connect('/users/edit_profile', array('plugin' => 'acl', 'controller' => 'users', 'action' => 'edit_profile'), $params);
Router::connect('/users/forgot_password', array('plugin' => 'acl', 'controller' => 'users', 'action' => 'forgot_password'), $params);
Router::connect('/users/activate_password/*', array('plugin' => 'acl', 'controller' => 'users', 'action' => 'activate_password'), $params);
Router::connect('/users/login', array('plugin' => 'acl', 'controller' => 'users', 'action' => 'login'), $params);
?>
