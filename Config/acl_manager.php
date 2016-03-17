<?php
/**
 * Acl Manager Config File
 *
 * This will be loaded by the AclManger plugin and merged into its configuration
 *
 * copy this file to your App/Config/ folder
 */

$config['AclManager'] = array(
	/**
	 * List of AROs (Class aliases)
	 * Order is important! Parent to Children
	 */
	'aros' => array('Role', 'User'),
	
	/**
	 * Aliases to write into ARO table
	 */
	// 'aro_aliases' => array('Group' => 'name', 'User' => 'username'),
	
	/**
	 * Limit used to paginate AROs
	 * Replace {alias} with ARO alias
	 * '{alias}' => array('limit' => 3)
	 */
	// 'Role' => array('limit' => 3),
	
	/**
	 * Routing Prefix
	 * Set the prefix you would like to restrict the plugin to
	 * @see Configure::read('Routing.prefixes')
	 */
	// 'prefix' => 'admin',
	
	/**
	 * Ugly identation?
	 * Turn off when using CSS
	 */
	'uglyIdent' => true,
					
	/**
	 * Actions to ignore when looking for new ACOs
	 * Format: 'action', 'Controller/action' or 'Plugin.Controller/action'
	 */
	'ignoreActions' => array('isAuthorized'),
	
	/**
	 * List of ARO models to load
	 * Use only if AclManager.aros aliases are different from model name
	 */
	// 'models' => array('Group', 'Customer'),
	
	'version' => "1.3.1"
);
