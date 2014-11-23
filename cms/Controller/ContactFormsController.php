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
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Controller.ContactForms
 */
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * ContactForms Controller
 *
 * @property ContactForm $ContactForm
 * @property Recaptcha $Recaptcha
 */
class ContactFormsController extends AppController {

/**
 * Models
 *
 * @var array
 */
	public $uses = array('ContactForm', 'ContactFormEmail');
/**
 * Components
 *
 * @var array
 */
	public $components = array('SimpleRecaptcha.SimpleRecaptcha');

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

			$result = $this->SimpleRecaptcha->verify($this->request->data['g-recaptcha-response']);
			if ($result['success'] === true) {
				if ($this->ContactForm->save($this->request->data)) {
					$this->_sendContactEmail($this->ContactForm->id);
					$this->Session->setFlash('The Contact Form message has been sent.', 'Flash/success');
					return $this->redirect(array('controller' => 'pages', 'action' => 'index'));
				} else {
					$this->Session->setFlash('The Contact Form message could not be sent. Please, try again.', 'Flash/error');
				}
			} else {
				$this->Session->setFlash('The Contact Form message could not be sent. Please, try again.', 'Flash/error');
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
		$this->set('title_for_layout', 'Contact Form messages');

		$this->Paginator->settings = array('recursive' => -1);
		$this->set('contactForms', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		if (!$this->ContactForm->exists($id)) {
			throw new NotFoundException('Invalid Contact Form message.');
		}
		$options = array('conditions' => array('ContactForm.id' => $id));
		$contactForm = $this->ContactForm->find('first', $options);
		$this->set(compact('contactForm'));
		$this->set('title_for_layout', 'Contact Form message');
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

		$this->ContactForm->id = $id;
		if (!$this->ContactForm->exists()) {
			throw new NotFoundException('Invalid Contact Form message.');
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ContactForm->delete()) {
			$this->Session->setFlash('Contact Form message deleted.', 'Flash/success');
			return $this->redirect(array('action' => 'admin_index'));
		}
		$this->Session->setFlash('Contact Form message was not deleted.', 'Flash/error');
		return $this->redirect(array('action' => 'admin_index'));
	}

/**
 * _sendContactEmail method
 *
 * Send a notification email that a new contact message has been saved.
 *
 * @param string $id
 * @return void
 */
	private function _sendContactEmail($id = null) {
		if (!$this->ContactForm->exists($id)) {
			throw new NotFoundException('Invalid Contact Form.');
		}
		$email = new CakeEmail();
		$options = array('conditions' => array('ContactForm.id' => $id));
		$contactForm = $this->ContactForm->find('first', $options);
		if ($contactForm) {
			$currentRecipients = $this->ContactFormEmail->find('active', array('fields' => array('ContactFormEmail.email')));

			$email->from(array('webmaster@example.com' => 'Site Webmaster'));
			$email->to($currentRecipients);
			$email->sender('webmaster@example.com', 'VFXfan CMS emailer');
			$email->subject('New Contact Message from Site');
			$email->emailFormat('both');
			$email->template('contact_form', 'default');
			$email->viewVars(array(
				'name' => $contactForm['ContactForm']['name'],
				'email' => $contactForm['ContactForm']['email'],
				'message' => $contactForm['ContactForm']['message']
			));
			$result = $email->send();
		}
    }

}
