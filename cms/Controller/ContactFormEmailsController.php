<?php
/**
 * Contact Form Emails controller.
 *
 * Contact Form Emails actions.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Controller.ContactFormEmails
 */
App::uses('AppController', 'Controller');
/**
 * ContactFormRecipients Controller
 *
 * @property ContactFormEmail $ContactFormEmail
 */
class ContactFormEmailsController extends AppController {

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';
		$this->set('title_for_layout', 'Contact Form Emails');

		$this->Paginator->settings = array('recursive' => -1);
		$this->set('contactFormEmails', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		if (!$this->ContactFormEmail->exists($id)) {
			throw new NotFoundException('Invalid Contact Form Email.');
		}
		$options = array('conditions' => array('ContactFormEmail.id' => $id));
		$contactFormEmail = $this->ContactFormEmail->find('first', $options);
		$this->set(compact('contactFormEmail'));
		$this->set('title_for_layout', 'Contact Form Email: '.$contactFormEmail['ContactFormEmail']['email']);
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'default_admin';
		if ($this->request->is('post')) {
			$this->ContactFormEmail->create();
			if ($this->ContactFormEmail->save($this->request->data)) {
				$this->Session->setFlash('The Contact Form Email has been saved.', 'Flash/success');
				return $this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Contact Form Email could not be saved. Please, try again.', 'Flash/error');
			}
		}
		$this->set('title_for_layout', 'Add Contact Form Email');
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->layout = 'default_admin';
		if (!$this->ContactFormEmail->exists($id)) {
			throw new NotFoundException('Invalid Contact Form Email.');
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ContactFormEmail->save($this->request->data)) {
				$this->Session->setFlash('The Contact Form Email has been saved.', 'Flash/success');
				return $this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Contact Form Email could not be saved. Please, try again.', 'Flash/error');
			}
		} else {
			$options = array('conditions' => array('ContactFormEmail.id' => $id));
			$this->request->data = $this->ContactFormEmail->find('first', $options);
		}
		$this->set('title_for_layout', 'Edit Contact Form Email');
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
		if (!$this->ContactFormEmail->exists($id)) {
			throw new NotFoundException('Invalid Contact Form Email.');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ContactFormEmail->delete()) {
			$this->Session->setFlash('Contact Form Email deleted.', 'Flash/success');
			return $this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Contact Form Email was not deleted.', 'Flash/error');
		return $this->redirect(array('action' => 'admin_index'));
	}
}
