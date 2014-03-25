<?php

$config ['Access'] = array(
    'users' => array(
      'name' => __d( 'admin', 'Usuarios'),
      'urls' => array(
           array(
                'admin' => true,
                'plugin' => 'acl',
                'controller' => 'users',
                'action' => 'add'
            ),
            array(
                'admin' => true,
                'plugin' => 'acl',
                'controller' => 'users',
                'action' => 'edit'
            ),
            array(
                'admin' => true,
                'plugin' => 'acl',
                'controller' => 'users',
                'action' => 'index'
            )
      )
    )
);
