<?php
/**
 * Events controller.
 *
 * Events actions.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Events.Controller
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
		$this->Auth->allow('archive');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Event->recursive = 0;
		$this->Paginator->settings = array(
			'conditions' => array('Event.date_end >= CURDATE()')
		);
		$this->set('title_for_layout', 'Upcoming Events');
		$this->set('events', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($slug = null) {
		if (!$slug) {
			throw new NotFoundException('Invalid Event.');
		}
		$event = $this->Event->findBySlug($slug);
		if (!$event) {
			throw new NotFoundException('Invalid Event.');
		}
		$this->set(compact('event'));
		$this->set('title_for_layout', 'Event: '.$event['Event']['name']);
	}

/**
 * archive method
 *
 * @return void
 */
	public function archive() {
		$this->Paginator->settings = array(
			'conditions' => array('Event.date_end <' => date('Y-m-d')), 'order' => array('Event.date_start' => 'DESC')
		);
		$this->Event->recursive = 0;
		$this->set('title_for_layout', 'Past Events');
		$this->set('events', $this->Paginator->paginate());
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';
		$this->Paginator->settings = array(
			'order' => array('Event.date_start' => 'DESC')
		);
		$this->Event->recursive = 0;
		$this->set('title_for_layout', 'Events');
		$this->set('events', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		if (!$this->Event->exists($id)) {
			throw new NotFoundException('Invalid Event.');
		}
		$options = array('conditions' => array('Event.id' => $id));
		$event = $this->Event->find('first', $options);
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
				$options = array('conditions' => array('Event.id' => $this->Event->id));
				$event = $this->Event->find('first', $options);
				if ($event) {
					$this->Upload->uploadImageThumb('img'.DS.'events'.DS.$event['Event']['year'], $this->request->data['File']['image'], $this->Upload->convertFilenameToId($this->Event->id, $this->request->data['File']['image']['name']));
				}
				$this->Session->setFlash('The Event has been saved.', 'Flash/success');
				return $this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Event could not be saved. Please, try again.', 'Flash/error');
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
		if (!$this->Event->exists($id)) {
			throw new NotFoundException('Invalid Event.');
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Event->save($this->request->data)) {
				$options = array('conditions' => array('Event.id' => $this->Event->id));
				$event = $this->Event->find('first', $options);
				if ($event) {
					$this->Upload->uploadImageThumb('img'.DS.'events'.DS.$event['Event']['year'], $this->request->data['File']['image'], $this->Upload->convertFilenameToId($this->Event->id, $this->request->data['File']['image']['name']));
				}
				$this->Session->setFlash('The Event has been saved.', 'Flash/success');
				return $this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Event could not be saved. Please, try again.', 'Flash/error');
			}
		} else {
			$options = array('conditions' => array('Event.id' => $id));
			$this->request->data = $this->Event->find('first', $options);
		}
		$this->set('title_for_layout', 'Edit Event');
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
		if (!$this->Event->exists($id)) {
			throw new NotFoundException('Invalid Event.');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Event->delete()) {
			$this->Session->setFlash('Event deleted.', 'Flash/success');
			return $this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Event was not deleted.', 'Flash/error');
		return $this->redirect(array('action' => 'admin_index'));
	}
}
