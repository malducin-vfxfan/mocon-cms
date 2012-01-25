<?php
/**
 * Events controller.
 *
 * Events actions.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       events
 * @subpackage    events.controller
 */
App::uses('AppController', 'Controller');
/**
 * Events Controller
 *
 * @property Event $Event
 * @property UploadComponent $Upload
 */
class EventsController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('FormatImage');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Upload');

/**
 * beforeFilter method
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('archive', 'upcomingEvents');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Event->recursive = 0;
		$this->paginate = array('conditions' => array('Event.date_end >= CURDATE()'));
		$this->set('title_for_layout', 'Upcoming Events');
		$this->set('events', $this->paginate());
	}

/**
 * archive method
 *
 * @return void
 */
	public function archive() {
		$this->paginate = array('conditions' => array('Event.date_end < CURDATE()'), 'order' => array('Event.date_start DESC'));
		$this->Event->recursive = 0;
		$this->set('title_for_layout', 'Past Events');
		$this->set('events', $this->paginate());
	}

/**
 * upcomingEvents method
 *
 * return a list of upcomin events.
 *
 * @return void
 */
	public function upcomingEvents($num_events = 5) {
		$events = $this->Event->getUpcoming($num_events);
		return $events;
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';
		$this->paginate = array('order' => array('Event.date_start DESC'));
		$this->Event->recursive = 0;
		$this->set('title_for_layout', 'Events');
		$this->set('events', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException('Invalid Event.');
		}
		$event = $this->Event->read(null, $id);
		$this->set(compact('event'));
		$this->set('title_for_layout', 'Event: ');
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'default_admin';
		if ($this->request->is('post')) {
			$this->Event->create();
			if ($this->Event->save($this->request->data)) {
				$event = $this->Event->read(null, $this->Event->id);
				$this->Upload->uploadImageThumb('img'.DS.'events'.DS.$event['Event']['year'], $this->request->data['File']['image'], $this->Upload->convertFilenameToId($this->Event->id, $this->request->data['File']['image']['name']));
				$this->Session->setFlash('The Event has been saved.', 'default', array('class' => 'message success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Event could not be saved. Please, try again.', 'default', array('class' => 'message failure'));
			}
		}
		$this->set('title_for_layout', 'Add Event');
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->layout = 'default_admin';
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException('Invalid Event.');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Event->save($this->request->data)) {
				$event = $this->Event->read(null, $this->Event->id);
				$this->Upload->uploadImageThumb('img'.DS.'events'.DS.$event['Event']['year'], $this->request->data['File']['image'], $this->Upload->convertFilenameToId($this->Event->id, $this->request->data['File']['image']['name']));
				$this->Session->setFlash('The Event has been saved.', 'default', array('class' => 'message success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Event could not be saved. Please, try again.', 'default', array('class' => 'message failure'));
			}
		} else {
			$this->request->data = $this->Event->read(null, $id);
		}
		$this->set('title_for_layout', 'Edit Event');
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
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException('Invalid Event.');
		}
		if ($this->Event->delete()) {
			$this->Session->setFlash('Event deleted.', 'default', array('class' => 'message success'));
			$this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Event was not deleted.', 'default', array('class' => 'message failure'));
		$this->redirect(array('action' => 'admin_index'));
	}
}
