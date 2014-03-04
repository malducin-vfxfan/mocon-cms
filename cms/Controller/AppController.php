<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       vfxfan-base.Controller
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
 * @package		vfxfan-base.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
/**
* VFXfan CMS system authorization
*
* The base system only uses authentication, meaning a logged in user is by
* default an administrator and can do anything. For better user control
* additonal methods have been implemented: ACL authorization and controller
* based authorizaed. ACL is enabled initially but the component and
* authorization can be easily commented out.
*
* In controller based authentication, an isAuthorized method is used to check
* users permissions. One is implemented here in the App Controller which
* mimcs the default behavior: Administrators can do anything. Controller
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
/**
 * Components
 *
 * @var array
 */
	public $components = array(
		'Acl',
		'Auth' => array(
			'authenticate' => array(
				'Form' => array(
					'passwordHasher' => array(
						'className' => 'BlowfishAdvanced'
					)
				)
			),
			'authorize' => array(
				'Actions' => array('actionPath' => 'controllers'), // use ACL based authorization
//				'Controller' // use controller based authorization
			)
		),
		'Paginator',
		'Security',
		'Session',
//		'DebugKit.Toolbar',
	);

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Form', 'Html', 'Menu', 'Session');

/**
 * beforeFilter method
 *
 * Set application wide settings, mainly security related ones. By
 * default let views named index and view be always accesible. Also set
 * CSRF duration, a blackhole callback and a session variable to select
 * the default or mobile theme.
 *
 * @return void
 */
	public function beforeFilter() {
		// always allow index and view access
		$this->Auth->allow(array('index', 'view'));

		// set the login and logout actions
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'admin_login');
		$this->Auth->loginRedirect = array('controller' => 'posts', 'action' => 'admin_index');
		$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'admin_login');
		$this->Auth->flash['element'] = 'Flash/auth';

		// set security options
		$this->Security->csrfExpires = '+10 minutes';
		$this->Security->blackHoleCallback = 'blackhole';
		$this->Security->requireAuth(array('admin_index', 'admin_view', 'admin_add', 'admin_edit', 'admin_delete'));
		Security::setHash('sha256');
		Security::setCost(Configure::read('Security.BlowfishAdvanced.cost'));

		// check to see if we are on a mobile device
		if (!$this->Session->check('Config.theme')) {
			if ($this->request->is('mobile')) {
				$this->Session->write('Config.theme', 'mobile');
			} else {
				$this->Session->write('Config.theme', 'default');
			}
		}

		// use the Mobile theme if configured
		if ($this->Session->read('Config.theme') == 'mobile') {
			$this->theme = 'Mobile';
		} else {
			$this->theme = null;
		}
		$this->response->vary('User-Agent');
	}

/**
 * isAuthorized method
 *
 * Generic application wide controller based authorization. By default
 * admin action require that the user be logged in and belong to the
 * Admin group.
 *
 * @return boolean
 */
	public function isAuthorized($user = null) {
		// Any registered user can access public functions
		if (empty($this->request->params['admin'])) { // could also check $this->request->prefix
			return true;
		}

		// Only admins can access admin functions
		if (isset($this->request->params['admin'])) { // could also check $this->request->prefix
			return (bool)($user['Group']['name'] === 'Administrators'); // could also check $this->Auth->user('Group.name')
		}

		// Default deny
		return false;
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
			$this->Session->setFlash('The Form has expired, please try again.', 'Flash/error');
			return $this->redirect(array('action' => $this->request->action));
		}
		elseif ($type == 'auth') {
			$this->Session->setFlash('There was a problem with the action (probably validation), please try again.', 'Flash/error');
			return $this->redirect(array('action' => $this->request->action));
		} else {
			throw new NotFoundException('Invalid action.');
		}
	}

}
