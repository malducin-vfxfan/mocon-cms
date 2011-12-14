<?php
/**
 * Contact Forms controller.
 *
 * Contact Forms actions. Store a contact form message and send an
 * email notification. Use the Recaptcha plugin from lamanabie at:
 * https://github.com/lamanabie/cakephp-recaptcha to make the form
 * more secure.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       contact_forms
 * @subpackage    contact_forms.controller
 */
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * ContactForms Controller
 *
 * @property ContactForm $ContactForm
 */
class ContactFormsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	var $components = array('Recaptcha.Recaptcha' => array('actions' => array('index')));

/**
 * index method
 *
 * Saves the message first and then send th message id to the send
 * message action.
 *
 * @return void
 */
	public function index() {
		if ($this->request->is('post')) {
			$this->ContactForm->create();
			if ($this->ContactForm->save($this->request->data)) {
				$this->_sendContactEmail($this->ContactForm->id);
				$this->Session->setFlash('The Contact Form message has been sent.', 'default', array('class' => 'message success'));
				$this->redirect(array('controller' => 'pages', 'action' => 'index'));
			} else {
				$this->Session->setFlash('The Contact Form message could not be sent. Please, try again.', 'default', array('class' => 'message failure'));
			}
		}
		$this->set('title_for_layout', 'Contact Us');
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';
		$this->ContactForm->recursive = -1;
		$this->set('title_for_layout', 'Contact Form messages');
		$this->set('contactForms', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		$this->ContactForm->id = $id;
		if (!$this->ContactForm->exists()) {
			throw new NotFoundException('Invalid Contact Form message.');
		}
		$contactForm = $this->ContactForm->read(null, $id);
		$this->set(compact('contactForm'));
		$this->set('title_for_layout', 'Contact Form message');
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
		$this->ContactForm->id = $id;
		if (!$this->ContactForm->exists()) {
			throw new NotFoundException('Invalid Contact Form message.');
		}
		if ($this->ContactForm->delete()) {
			$this->Session->setFlash('Contact Form message deleted.', 'default', array('class' => 'message success'));
			$this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Contact Form message was not deleted.', 'default', array('class' => 'message failure'));
		$this->redirect(array('action' => 'admin_index'));
	}

/**
 * _sendContactEmail method
 *
 * Send a notification email that a new contact message has been saved.
 *
 * @param string $id
 * @return void
 */
	private function _sendContactEmail($id) {
		$email = new CakeEmail();
		$contact_form = $this->ContactForm->read(null, $id);

		$email->from(array('webmaster@example.com' => 'Site Webmaster'));
		$email->to('webmaster@example.com');
		$email->sender('webmaster@example.com', 'VFXfan CMS emailer');
		$email->subject('New Contact Message from Site');
		$email->emailFormat('both');
		$email->template('contact_form', 'default');
		$email->viewVars(array(
			'name' => $contact_form['ContactForm']['name'],
			'email' => $contact_form['ContactForm']['email'],
			'message' => $contact_form['ContactForm']['message']
		));
		$result = $email->send();
    }

}
