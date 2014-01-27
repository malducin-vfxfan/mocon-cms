<?php
/**
 * ACL Permissions controller.
 *
 * ACL Permissions actions.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Controller.AclPermissions
 */
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class AclPermissionsController extends AppController {
/**
 * Models to use
 *
 * @var array
 */
	public $uses = array('User', 'Aco');
/**
 * Root node name.
 *
 * @var string
 **/
	public $rootNode = 'controllers';

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';

		$options = array(
			'conditions' => array('alias' => $this->rootNode),
			'recursive' => -1
		);
		$rootAco = $this->Acl->Aco->find('first', $options);

		$this->Paginator->settings = array(
			'conditions' => array('parent_id' => $rootAco['Aco']['id']),
			'order' => array('lft'),
			'recursive' => -1
		);

		$this->set('title_for_layout', 'Top Level ACOs');
		$this->set('acos', $this->Paginator->paginate('Aco'));
		$this->set(compact('rootAco'));

	}

/**
 * admin_methods method
 *
 * @param string $id
 * @return void
 */
	public function admin_methods($aco_id = null) {
		$this->layout = 'default_admin';

		if (!$aco_id) {
			throw new NotFoundException('Invalid ACO.');
		}
		$controllerPath = $this->Acl->Aco->getPath($aco_id);
		if (!$controllerPath) {
			throw new NotFoundException('Invalid ACO.');
		}
		$pathComponents = array();
		foreach ($controllerPath as $path_component) {
			$pathComponents[] =  $path_component['Aco']['alias'];
		}
		$completePath = implode('/', $pathComponents);

		$controllerMethods = $this->Acl->Aco->children($aco_id, true);
		if (!$controllerMethods) {
			$this->Session->setFlash('No methods found for this controller (ACO).', 'default', array('class' => 'alert alert-info'));
			return $this->redirect(array('action' => 'admin_index'));
		}

		$this->set('title_for_layout', 'Methods - Controller ACOs: '.$completePath);
		$this->set(compact('controllerPath', 'completePath', 'controllerMethods'));
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($aco_id = null) {
		$this->layout = 'default_admin';

		$path = $this->Acl->Aco->getPath($aco_id);
		if (!$path) {
			throw new NotFoundException('Invalid ACO.');
		}

		$pathComponents = array();
		foreach ($path as $path_component) {
			$pathComponents[] =  $path_component['Aco']['alias'];
		}
		$completePath = implode('/', $pathComponents);

		$this->Paginator->settings = array('recursive' => 0);
		$users = $this->Paginator->paginate('User');

		// attach groups and users permission information
		foreach ($users as &$user) {
			$user['User']['permission'] = $this->Acl->check(array('User' => array('id' => $user['User']['id'])), $completePath);
			$user['Group']['permission'] = $this->Acl->check(array('Group' => array('id' => $user['Group']['id'])), $completePath);
		}
		unset($user);

		$this->set('title_for_layout', 'ARO Permissions: '.$completePath);
		$this->set(compact('aco_id', 'users', 'path', 'completePath'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($aco_id = null, $model = 'User', $id = null) {
		$this->layout = 'default_admin';

		if ($this->request->is(array('post', 'put'))) {
			$path = $this->Acl->Aco->getPath($aco_id);
			if (!$path) {
				throw new NotFoundException('Invalid ACO.');
			}

			$pathComponents = array();
			foreach ($path as $path_component) {
				$pathComponents[] =  $path_component['Aco']['alias'];
			}
			$completePath = implode('/', $pathComponents);

			$permission = $this->Acl->check(array($model => array('id' => $id)), $completePath);

			switch ($model) {
				case 'User':
					if (!$this->User->exists($id)) {
						throw new NotFoundException('Invalid User.');
					}
					if ($permission) {
						$this->Acl->deny(array('model' => 'User', 'foreign_key' => $id), $completePath);
					} else {
						$this->Acl->allow(array('model' => 'User', 'foreign_key' => $id), $completePath);
					}

					break;

				case 'Group':
					if (!$this->User->Group->exists($id)) {
						throw new NotFoundException('Invalid Group.');
					}

					if ($permission) {
						$this->Acl->deny(array('model' => 'Group', 'foreign_key' => $id), $completePath);
					} else {
						$this->Acl->allow(array('model' => 'Group', 'foreign_key' => $id), $completePath);
					}

					break;

				default:
					throw new NotFoundException('Invalid ARO model.');
					break;
			}

			$this->Session->setFlash('The ACL Permission has been changed and/or added.', 'Flash/success');
			return $this->redirect(array('action' => 'admin_view', $aco_id));
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($aco_id = null, $model = 'User', $id = null) {
		$this->layout = 'default_admin';

		$this->request->onlyAllow('post', 'delete');

		$path = $this->Acl->Aco->getPath($aco_id);
		if (!$path) {
			throw new NotFoundException('Invalid ACO.');
		}

		switch ($model) {
			case 'User':
				$this->User->id = $id;
				if (!$this->User->exists()) {
					throw new NotFoundException('Invalid User.');
				}

				$aro = $this->Acl->Aro->find('first', array('conditions' => array('model' => 'User', 'foreign_key' => $id)));
				$permission = $this->Acl->Aco->Permission->find('first', array('conditions' => array('aco_id' => $aco_id, 'aro_id' => $aro['Aro']['id'])));
				$this->Acl->Aco->Permission->delete($permission['Permission']['id'], false);

				break;

			case 'Group':
				$this->User->Group->id = $id;
				if (!$this->User->Group->exists()) {
					throw new NotFoundException('Invalid Group.');
				}

				$aro = $this->Acl->Aro->find('first', array('conditions' => array('model' => 'Group', 'foreign_key' => $id)));
				$permission = $this->Acl->Aco->Permission->find('first', array('conditions' => array('aco_id' => $aco_id, 'aro_id' => $aro['Aro']['id'])));
				$this->Acl->Aco->Permission->delete($permission['Permission']['id'], false);

				break;

			default:
				throw new NotFoundException('Invalid ARO model.');
				break;
		}

		$this->Session->setFlash('The ACL Permission has been deleted.', 'Flash/success');
		return $this->redirect(array('action' => 'admin_view', $aco_id));
	}

/**
 * admin_installed_controllers method
 *
 * @return void
 */
	public function admin_installed_controllers() {
		$this->layout = 'default_admin';

		// get controllers and plugins
		$controllers = $this->getControllerList();
		$plugins = CakePlugin::loaded();
		foreach ($plugins as $plugin) {
			$pluginControllers = $this->getControllerList($plugin);
		}

		$this->set('title_for_layout', 'Controllers and Plugins');
		$this->set(compact('controllers', 'plugins', 'pluginControllers'));
	}

/**
 * Updates the Aco Tree with new controller actions.
 *
 * @return void
 **/
	public function admin_aco_update() {
		$this->layout = 'default_admin';

		// check the root node exists
		$root = $this->_checkNode($this->rootNode, $this->rootNode, null);
		// make sure administrators have access to everything
		$this->initDB();
		$controllers = $this->getControllerList();
		$this->_updateControllers($root, $controllers);

		$plugins = CakePlugin::loaded();
		foreach ($plugins as $plugin) {
			$controllers = $this->getControllerList($plugin);

			$path = $this->rootNode . '/' . $plugin;
			$pluginRoot = $this->_checkNode($path, $plugin, $root['Aco']['id']);
			$this->_updateControllers($pluginRoot, $controllers, $plugin);
		}

		$this->Session->setFlash('The ACOs have been updated.', 'default', array('class' => 'alert alert-info'));
		return $this->redirect(array('action' => 'admin_index'));
	}

/**
 * Check a node for existance, create it if it doesn't exist.
 *
 * @param string $path
 * @param string $alias
 * @param int $parentId
 * @return array Aco Node array
 */
	private function _checkNode($path, $alias, $parentId = null) {
		$node = $this->Acl->Aco->node($path);
		if (!$node) {
			$this->Acl->Aco->create(array('parent_id' => $parentId, 'model' => null, 'alias' => $alias));
			$node = $this->Acl->Aco->save();
			$node['Aco']['id'] = $this->Acl->Aco->id;
			$node['Aco']['created'] = true;
		} else {
			$node = $node[0];
			$node['Aco']['created'] = false;
		}
		return $node;
	}

/**
 * Initialize the ACL system.
 *
 * @return void
 **/
	private function initDB() {

		$options = array('conditions' => array('Group.name' => 'Administrators'));
		$adminGroup = $this->User->Group->find('first', $options);

		//Allow admins to everything
		$this->Acl->allow(array('model' => 'Group', 'foreign_key' => $adminGroup['Group']['id']), $this->rootNode);
	}

/**
 * Get a list of controllers in the app and plugins.
 *
 * Returns an array of path => import notation.
 *
 * @param string $plugin Name of plugin to get controllers for
 * @return array
 **/
	private function getControllerList($plugin = null) {
		if (!$plugin) {
			$controllers = App::objects('Controller', null, false);
		} else {
			$controllers = App::objects($plugin.'.Controller', null, false);
		}
		return $controllers;
	}

/**
 * Updates a collection of controllers.
 *
 * @param array $root Array or ACO information for root node.
 * @param array $controllers Array of Controllers
 * @param string $plugin Name of the plugin you are making controllers for.
 * @return void
 */
	private function _updateControllers($root, $controllers, $plugin = null) {
		$dotPlugin = $pluginPath = $plugin;
		if ($plugin) {
			$dotPlugin .= '.';
			$pluginPath .= '/';
		}

		// get the index of the AppController, unset it if found
		$appIndex = array_search($plugin.'AppController', $controllers);
		if ($appIndex !== false) {
			App::uses($plugin.'AppController', $dotPlugin.'Controller');
			unset($controllers[$appIndex]);
		}

		// look at each controller
		foreach ($controllers as $controller) {
			// load the controller and/or plugin class
			App::uses($controller, $dotPlugin . 'Controller');
			$controllerName = preg_replace('/Controller$/', '', $controller);
			$path = $this->rootNode.'/'.$pluginPath.$controllerName;

			// check that the controller exists
			$controllerNode = $this->_checkNode($path, $controllerName, $root['Aco']['id']);

			// get the methods for the controller to add them
			$this->_checkMethods($controller, $controllerName, $controllerNode, $pluginPath);
		}

		// check if we have the same application controllers as the
		// ones in the database, if not we need to delete them
		// add plugins to the controllers list and flip it
		if (!$plugin) {
			$controllers = array_merge($controllers, App::objects('plugin', null, false));
		}
		$controllerFlip = array_flip($controllers);

		// get the root node and all its children
		$this->Acl->Aco->id = $root['Aco']['id'];
		$controllerNodes = $this->Acl->Aco->children(null, true);

		// check the controller nodes
		foreach ($controllerNodes as $ctrlNode) {
			$alias = $ctrlNode['Aco']['alias'];
			$name = $alias.'Controller';

			// see if the alias or controller name in the database
			// is set in the controller list, if not delete it
			if (!isset($controllerFlip[$name]) && !isset($controllerFlip[$alias])) {
				$this->Acl->Aco->delete($ctrlNode['Aco']['id']);
			}
		}
	}

/**
 * Check and add/delete controller methods
 *
 * @param string $controller
 * @param array $node
 * @param string $plugin Name of plugin
 * @return void
 */
	private function _checkMethods($className, $controllerName, $node, $pluginPath = false) {
		$baseMethods = get_class_methods('Controller'); // base methods in AppController
		$actions = get_class_methods($className);  // methods in the controller
		$methods = array_diff($actions, $baseMethods); // all methods in the controller plus the base methods

		// check to see
		foreach ($methods as $action) {
			// if the method is protected or private, skip it
			$method = new ReflectionMethod($className, $action);
			if (!$method->isPublic()) {
				continue;
			}
			$path = $this->rootNode.'/'.$pluginPath.$controllerName.'/'.$action;
			$this->_checkNode($path, $action, $node['Aco']['id']);
		}

		// check if we have the same application controllers methods as the
		// ones in the database, if not we need to delete them
		$actionNodes = $this->Acl->Aco->children($node['Aco']['id']); // get the method names in the DB
		$methodFlip = array_flip($methods); // flip the array so that method names are keys
		foreach ($actionNodes as $action) {
			// check to see if an ACO alias doesn't exist in the controller methods and delete
			if (!isset($methodFlip[$action['Aco']['alias']])) {
				$this->Acl->Aco->id = $action['Aco']['id'];
				if ($this->Acl->Aco->delete()) {
					$path = $this->rootNode.'/'.$controllerName.'/'.$action['Aco']['alias'];
				}
			}
		}
		return true;
	}

}