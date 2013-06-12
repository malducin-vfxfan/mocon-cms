<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
/**
 * Components
 *
 * @var array
 */
	public $components = array('Acl', 'Auth', 'Security', 'Session');

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Form', 'Html', 'Session');

/**
 * beforeFilter method
 *
 * Set application wide settings, mainly security related ones. By
 * default let views named indexand view be always accesible. Also set
 * CSRF duration, a blackhole callback and security of basic admin
 * methods depending on the request type.
 *
 * @return void
 */
	public function beforeFilter() {
		// always allow index and view access
		$this->Auth->allow('index', 'view');

		// set the login and logout actions
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'admin_login');
		$this->Auth->loginRedirect = array('controller' => 'posts', 'action' => 'admin_index');
		$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'admin_login');

/**
* VFXfan CMS system authorization
*
* The base system only uses authentication, meaning a logged in user is by
* default an administrator and acn do anything. For better user control to
* additonal methods have been implemented, but disabled by default: ACL
* authorization and controller based authorizaed. Just uncomment one below.
*
* In controller based authentication, an isAuthorized method is used to check
* users permissions. One is implemented here in the App Controller which
* mimcs the default behavior: Administrators acn do anything. Controller
* based authorization is useful if only a few groups are needed and only
* a few groups require special authorization.
*
* ACL allows more fine-grained permissions. To use uncomment the lines below
* and also the actsAs variables in the User and Group models. Allow
* access to the system, update the ACOs, which allows Aministrators access
* to the whole system. Then only allow the index and view views. Create
* the AROs and ACOs tables first, schema can be found at:
*
* app/Config/Schema/db_acl.sql
*/
		// use ACL based authorization
//		$this->Auth->authorize = array('Actions' => array('actionPath' => 'controllers'),);

		// use controller based authorization
//		$this->Auth->authorize = 'Controller';

		// set security options
		$this->Security->csrfExpires = '+10 minutes';
		$this->Security->blackHoleCallback = 'blackhole';
		$this->Security->requireAuth(array('admin_index', 'admin_view', 'admin_add', 'admin_edit', 'admin_delete'));
		$this->Security->requireGet(array('admin_index', 'admin_view', 'admin_logout'));
		$this->Security->requirePost(array('admin_delete'));
		if (!empty($this->request->data)) {
			if ($this->request->action == 'admin_add')
				$this->Security->requirePost(array('admin_add'));
			if ($this->request->action == 'admin_login')
				$this->Security->requirePost(array('admin_login'));
			if ($this->request->action == 'admin_edit') {
				if ($this->request->is('put'))
					$this->Security->requirePut(array('admin_edit'));
				elseif ($this->request->is('post'))
					$this->Security->requirePost(array('admin_edit'));
			}
		}

		// check to see if we are on a mobile device
		if (!$this->Session->check('Config.theme')) {
			if ($this->request->is('mobile')) {
				$this->Session->write('Config.theme', 'mobile');
			}
			else {
				$this->Session->write('Config.theme', 'default');
			}
		}

		// use the Mobile theme if configured
		if ($this->Session->read('Config.theme') == 'mobile') {
			$this->theme = 'Mobile';
		}
		else {
			$this->theme = null;
		}
		$this->response->vary('User-Agent');
	}

/**
 * isAuthorized method
 *
 * Generic application wide controller based authorization. By default
 * admin action require that the user be logged in and belong to the
 * Admin group. All other actions are allowed be default.
 *
 * In order to use, the authorize setting in beforeFilter must be
 * commented out.
 *
 * @return boolean
 */
	public function isAuthorized() {
		// id action starts with admin_, check if the user belongs to the Admin group
		if (strpos($this->request->action, 'admin_') !== false) {
			if ($this->Auth->user('groupName') == 'Administrators') {
				return true;
			}
			else {
				return false;
			}
		}
		return true;
	}

/**
 * blackhole method
 *
 * Generic application wide blackhole callback. If the problem is
 * related to CSRF protection of forms, mainly that the token has
 * expired, it redirects to the action again, thus regenarating the
 * token. If the problem is Auth related, mainly action mismatches or
 * forms that don't validate, it redirects to the action again. All
 * other problems throw a Not Found Exception, which shows the 400
 * error page that redirects to the main page.
 *
 * @return void
 */
	public function blackhole($type) {
		if ($type == 'csrf') {
			$this->Session->setFlash('The Form has expired, please try again.', 'default', array('class' => 'alert alert-error'));
			$this->redirect(array('action' => $this->request->action));
		}
		elseif ($type == 'auth') {
			$this->Session->setFlash('There was a problem with the action (probably validation), please try again.', 'default', array('class' => 'alert alert-error'));
			$this->redirect(array('action' => $this->request->action));
		}
		else {
			throw new NotFoundException('Invalid action.');
		}
	}

}
