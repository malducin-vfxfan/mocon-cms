<?php
/**
 * Contact Form Emails controller.
 *
 * Contact Form Emails actions.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       contact_form_emails
 * @subpackage    contact_form_emails.controller
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
		$this->ContactFormEmail->recursive = -1;
		$this->set('title_for_layout', 'Contact Form Emails');
		$this->set('contactFormEmails', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		$this->ContactFormEmail->id = $id;
		if (!$this->ContactFormEmail->exists()) {
			throw new NotFoundException('Invalid Contact Form Email.');
		}
		$contactFormEmail = $this->ContactFormEmail->find('first', array('conditions' => array('ContactFormEmail.id' => $id)));
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
				$this->Session->setFlash('The Contact Form Email has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Contact Form Email could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
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
		$this->ContactFormEmail->id = $id;
		if (!$this->ContactFormEmail->exists()) {
			throw new NotFoundException('Invalid Contact Form Email.');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ContactFormEmail->save($this->request->data)) {
				$this->Session->setFlash('The Contact Form Email has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Contact Form Email could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
			}
		} else {
			$this->request->data = $this->ContactFormEmail->read(null, $id);
		}
		$this->set('title_for_layout', 'Edit Contact Form Email');
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
		$this->ContactFormEmail->id = $id;
		if (!$this->ContactFormEmail->exists()) {
			throw new NotFoundException('Invalid Contact Form Email.');
		}
		if ($this->ContactFormEmail->delete()) {
			$this->Session->setFlash('Contact Form Email deleted.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Contact Form Email was not deleted.', 'default', array('class' => 'alert alert-error'));
		$this->redirect(array('action' => 'admin_index'));
	}
}
