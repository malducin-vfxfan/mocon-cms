<?php
/**
 * Groups controller.
 *
 * Groups actions.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       groups
 * @subpackage    groups.controller
 */
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 */
class GroupsController extends AppController {

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';
		$this->Group->recursive = 0;
		$this->set('title_for_layout', 'Groups');
		$this->set('groups', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		$this->Group->recursive = -1;
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException('Invalid Group.');
		}
		$this->Group->unbindModel(array('hasMany' => array('User')));
		$group = $this->Group->find('first', array('conditions' => array('Group.id' => $id)));
		$this->set(compact('group'));
		$this->set('title_for_layout', 'Group: '.$group['Group']['name']);
		$this->Group->User->recursive = -1;
		$this->set('users', $this->paginate('User', array('User.group_id' => $group['Group']['id'])));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'default_admin';
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash('The Group has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Group could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
			}
		}
		$this->set('title_for_layout', 'Add Group');
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->layout = 'default_admin';
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException('Invalid Group.');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash('The Group has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Group could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
			}
		} else {
			$this->request->data = $this->Group->read(null, $id);
		}
		$this->set('title_for_layout', 'Edit Group');
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
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException('Invalid Group.');
		}
		if ($this->Group->delete()) {
			$this->Session->setFlash('Group deleted.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Group was not deleted.', 'default', array('class' => 'alert alert-error'));
		$this->redirect(array('action' => 'admin_index'));
	}
}
