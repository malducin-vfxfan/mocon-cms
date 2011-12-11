<?php
/**
 * Events controller.
 *
 * Events controller.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    Events
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
	var $helpers = array('FormatImage');
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
		$this->set('title_for_layout', 'Events');
		$this->set('events', $this->paginate());
	}

/**
 * archive method
 *
 * @return void
 */
	public function archive() {
		$this->Event->recursive = 0;
		$this->set('title_for_layout', 'Past Events');
		$this->set('events', $this->paginate('Event', array('Event.date_end < CURDATE()')));
	}

/**
 * upcomingEvents method
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
			throw new NotFoundException('Invalid Event');
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
				$this->Upload->uploadImageThumb('img'.DS.'events', $this->data['File']['image'], $this->Upload->convertFilenameToId($this->Event->id, $this->data['File']['image']['name']));
				$this->Session->setFlash('The Event has been saved', 'default', array('class' => 'message success'));
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
			throw new NotFoundException('Invalid Event');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Event->save($this->request->data)) {
				$this->Upload->uploadImageThumb('img'.DS.'events', $this->data['File']['image'], $this->Upload->convertFilenameToId($this->Event->id, $this->data['File']['image']['name']));
				$this->Session->setFlash('The Event has been saved', 'default', array('class' => 'message success'));
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
			throw new NotFoundException('Invalid Event');
		}
		if ($this->Event->delete()) {
			$this->Session->setFlash('Event deleted', 'default', array('class' => 'message success'));
			$this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Event was not deleted', 'default', array('class' => 'message failure'));
		$this->redirect(array('action' => 'admin_index'));
	}
}
