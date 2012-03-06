# AclManager for CakePHP 2.x

This plugins allows you to easily manage your permissions in CakePHP 2.x through the Acl module.
Features
========

* Managing permissions for each node
* Updating Database with missing AROs (Users, Roles, ...)
* Updating Database with missing ACOs (Controller actions)
* Revoking all permissions

Requirements
------------

* CakePHP 2.x

How to install
--------------

1. Set up your Acl environment (see any tutorial)

   * Install SQL tables through Cake Console
   * parentNode() method on your requester models

2. Configure Auth in your AppController

It should look something like this:

	var $components = array('Auth', 'Acl', 'Session');
	
    function beforeFilter() {
    	
        //Configure AuthComponent
        $this->Auth->authorize = array(
        	'Controller',
        	'Actions' => array('actionPath' => 'controllers')
        );
		$this->Auth->authenticate = array('Form' => array('fields' => array('username' => 'login', 'password' => 'password')));
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => false, 'plugin' => false);
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login', 'admin' => false, 'plugin' => false);
        $this->Auth->loginRedirect = array('controller' => 'products', 'action' => 'index', 'admin' => false, 'plugin' => false);
        
    }

    function isAuthorized($user) {
        // return false;
        return $this->Auth->loggedIn();
    }

3. Download AclManager to the `app/Plugin` directory

4. Configure the plugin, see `AclManager/Config/bootstrap.php`

AclManager.aros : write in there your requester models aliases (the order is important)

5. Enable the plugin in `app/Config/bootstrap.php`

    CakePlugin::load('AclManager', array('bootstrap' => true));

6. Access the plugin at `/acl_manager/acl`

   * Update your AROs and ACOs
   * Set up your permissions (do not forget to enable your own public actions !)
   
7. Disable the authorizer Controller or uncomment `return false` in `AppController::isAuthorized()`

8. You're done!

Enjoy!
