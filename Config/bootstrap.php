<?php

// Valores por defecto
Configure::write( 'Acl.defaults.group', 'member');
Configure::write( 'Acl.defaults.active', 1);

// Load a 'default' Acl configuration for use in the application from app/Config/acl.php
Configure::load( 'acl');