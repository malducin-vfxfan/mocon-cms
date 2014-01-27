<?php
/**
 * Users controller.
 *
 * Users actions.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Controller.Users
 */
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

/**
 * admin_login method
 *
 * @return void
 */
	public function admin_login() {
		$this->layout = 'default_login';
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Session->setFlash('Username or password is incorrect.', 'default', array('class' => 'alert alert-danger'), 'auth');
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
		return $this->redirect($this->Auth->logout());
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';
		$this->set('title_for_layout', 'Users');

		$this->Paginator->settings = array('recursive' => 0);
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';

		if (!$this->User->exists($id)) {
			throw new NotFoundException('Invalid User.');
		}

		$options = array(
			'conditions' => array('User.id' => $id),
			'recursive' => 0
		);
		$user = $this->User->find('first', $options);
		$this->set(compact('user'));
		$this->set('title_for_layout', 'User: '.$user['User']['username']);

		$this->Paginator->settings = array(
			'conditions' => array('Post.user_id' => $user['User']['id']),
			'recursive' => -1
		);
		$this->set('posts', $this->Paginator->paginate('Post'));
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
				$this->Session->setFlash('The User has been saved.', 'Flash/success');
				return $this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The User could not be saved. Please, try again.', 'Flash/error');
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set('title_for_layout', 'Add User');
		$this->set(compact('groups'));
	}

/**
 * admin_edit method
 *
 * Uses a dummy password field (passwd) to see if a new user password
 * is being set. If no new password is being set it only save the
 * username and group id. If a new password is set the dummy field is
 * used to fill the password field to be hashed upon saving.
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->layout = 'default_admin';
		if (!$this->User->exists($id)) {
			throw new NotFoundException('Invalid User.');
		}
		if ($this->request->is(array('post', 'put'))) {
			if (!$this->request->data('User.passwd')) {
				unset($this->request->data['User']['passwd']);
				if ($this->User->save($this->request->data, array('fieldList' => array('username', 'group_id')))) {
					$this->Session->setFlash('The User has been saved.', 'Flash/success');
					return $this->redirect(array('action' => 'admin_index'));
				} else {
					$this->Session->setFlash('The User could not be saved. Please, try again.', 'Flash/error');
				}
			} else {
				$this->request->data('User.password', $this->request->data('User.passwd'));
				unset($this->request->data['User']['passwd']);
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash('The User has been saved.', 'Flash/success');
					return $this->redirect(array('action' => 'admin_index'));
				} else {
					$this->Session->setFlash('The User could not be saved. Please, try again.', 'Flash/error');
				}
			}
		} else {
			$options = array('conditions' => array('User.id' => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
		$this->set('title_for_layout', 'Edit User');
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->layout = 'default_admin';

		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException('Invalid User.');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash('User deleted.', 'Flash/success');
			return $this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('User was not deleted.', 'Flash/error');
		return $this->redirect(array('action' => 'admin_index'));
	}

}
