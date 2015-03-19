<?php
/**
 * Acl Manager
 *
 * A CakePHP Plugin to manage Acl
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author        Frédéric Massart - FMCorz.net
 * @copyright     Copyright 2011, Frédéric Massart
 * @link          http://github.com/FMCorz/AclManager
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

// Default to Plugin config which can be overwritten by local app config
Configure::load('AclManager.acl_manager');
$defaultConfig = Configure::read('AclManager');

$config = array();
// Local app config
if (file_exists(APP . 'Config' . DS . 'acl_manager.php')) {
	Configure::load('acl_manager', 'default', false);
	$config = Configure::read('AclManager');
}

$config = array_merge($defaultConfig, $config);
Configure::write('AclManager', $config);

if (!Configure::read('AclManager.models')) {
	Configure::write('AclManager.models', Configure::read('AclManager.aros'));
}
