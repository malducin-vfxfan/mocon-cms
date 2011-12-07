<?php
/**
 * Users controller.
 *
 * Users controller.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    users
 */
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

/**
 * beforeFilter method
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		Security::setHash('sha256');
 		if ($this->request->action == 'admin_login') {
 			$this->Security->csrfExpires = '+30 minutes';
 			$this->Security->csrfUseOnce = false;
 		}
	}

/**
 * admin_login method
 *
 * @return void
 */
	public function admin_login() {
		$this->layout = 'default_login';
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$user_data = $this->User->read(null, $this->Auth->user('id'));
				$this->Session->write('Auth.User.groupName', $user_data['Group']['name']);
				return $this->redirect(array('controller' => 'posts', 'action' => 'admin_index'));
			}
			else {
				$this->Session->setFlash('Username or password is incorrect', 'default', array('class' => 'message failure'), 'auth');
			}
		}
		$this->set('title_for_layout', 'Login');
	}

/**
 * admin_logout method
 *
 * @return void
 */
	public function admin_logout() {
		$this->layout = 'default_login';
		$this->Session->destroy();
		$this->Auth->logout();
		$this->redirect(array('controller' => 'users', 'action' => 'admin_login'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';
		$this->User->recursive = 0;
		$this->set('title_for_layout', 'Users');
		$this->set('users', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		$this->User->recursive = 0;
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException('Invalid User');
		}
		$user = $this->User->read(null, $id);
		$this->set(compact('user'));
		$this->set('title_for_layout', 'User: '.$user['User']['username']);
		$this->User->Post->recursive = -1;
		$this->set('posts', $this->paginate('Post', array('Post.user_id' => $user['User']['id'])));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'default_admin';
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('The User has been saved.', 'default', array('class' => 'message success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The User could not be saved. Please, try again.', 'default', array('class' => 'message failure'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set('title_for_layout', 'Add User');
		$this->set(compact('groups'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->layout = 'default_admin';
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException('Invalid User.');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if (!$this->request->data('User.passwd')) {
				unset($this->request->data['User']['passwd']);
				if ($this->User->save($this->request->data, array('fieldList' => array('username', 'group_id')))) {
					$this->Session->setFlash('The User has been saved.', 'default', array('class' => 'message success'));
					$this->redirect(array('action' => 'admin_index'));
				} else {
					$this->Session->setFlash('The User could not be saved. Please, try again.', 'default', array('class' => 'message failure'));
				}
			}
			else {
				$this->request->data('User.password', $this->request->data('User.passwd'));
				unset($this->data['User']['passwd']);
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash('The User has been saved.', 'default', array('class' => 'message success'));
					$this->redirect(array('action' => 'admin_index'));
				} else {
					$this->Session->setFlash('The User could not be saved. Please, try again.', 'default', array('class' => 'message failure'));
				}
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
		$this->set('title_for_layout', 'Edit User');
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->layout = 'default_admin';
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException('Invalid User.');
		}
		if ($this->User->delete()) {
			$this->Session->setFlash('User deleted.', 'default', array('class' => 'message success'));
			$this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('User was not deleted.', 'default', array('class' => 'message failure'));
		$this->redirect(array('action' => 'admin_index'));
	}

}
