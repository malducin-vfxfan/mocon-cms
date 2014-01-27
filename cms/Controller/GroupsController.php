<?php
/**
 * Groups controller.
 *
 * Groups actions.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Controller.Groups
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
		$this->set('title_for_layout', 'Groups');

		$this->Paginator->settings = array('recursive' => 0);
		$this->set('groups', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';

		if (!$this->Group->exists($id)) {
			throw new NotFoundException('Invalid Group.');
		}

		$options = array(
			'conditions' => array('Group.id' => $id),
			'recursive' => -1
		);
		$group = $this->Group->find('first', $options);
		$this->set(compact('group'));
		$this->set('title_for_layout', 'Group: '.$group['Group']['name']);

		$this->Paginator->settings = array(
			'conditions' => array('User.group_id' => $group['Group']['id']),
			'recursive' => -1
		);
		$this->set('users', $this->Paginator->paginate('User'));
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
				$this->Session->setFlash('The Group has been saved.', 'Flash/success');
				return $this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Group could not be saved. Please, try again.', 'Flash/error');
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
		if (!$this->Group->exists($id)) {
			throw new NotFoundException('Invalid Group.');
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash('The Group has been saved.', 'Flash/success');
				return $this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Group could not be saved. Please, try again.', 'Flash/error');
			}
		} else {
			$options = $options = array('conditions' => array('Group.id' => $id));
			$this->request->data = $this->Group->find('first', $options);
		}
		$this->set('title_for_layout', 'Edit Group');
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

		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException('Invalid Group.');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Group->delete()) {
			$this->Session->setFlash('Group deleted.', 'Flash/success');
			return $this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Group was not deleted.', 'Flash/error');
		return $this->redirect(array('action' => 'admin_index'));
	}
}
