<?php
/**
 * Pages controller.
 *
 * Pages actions. Can save related page sections during the creation
 * of a new page, but validation of extra sections is skipped. Also
 * upload page images one at a time and delete them.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       pages
 * @subpackage    pages.controller
 */
App::uses('AppController', 'Controller');
/**
 * Pages Controller
 *
 * @property Page $Page
 * @property UploadComponent $Upload
 * @property RequestHandlerComponent $RequestHandler
 */
class PagesController extends AppController {

/**
 * Models
 *
 * @var array
 */
	public $uses = array('Page', 'Post', 'Event');
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
 * Pagination
 *
 * @var array
 */
	public $paginate = array('PageSection' => array('limit' => 1));

/**
 * beforeFilter method
 *
 * Disable other page section fields from validation during creation
 * of new page. The for loop limit should match the maximum number of
 * possible page sections (established on the page forms script).
 *
 * @return void
 */
 	public function beforeFilter() {
 		parent::beforeFilter();
 		if ($this->request->action == 'admin_add') {
 			$unlocked_add_fields = array();
 			for ($i = 1; $i < 6; $i++) {
 				$unlocked_add_fields[] = 'PageSection.'.$i.'.title';
 				$unlocked_add_fields[] = 'PageSection.'.$i.'.section';
 				$unlocked_add_fields[] = 'PageSection.'.$i.'.content';
 			}
			$this->Security->unlockedFields = $unlocked_add_fields;
		}
 	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Page->recursive = 1;

		// get cached latest posts, if expired find the latest
		$posts = Cache::read('latest_posts');
		if ($posts === false) {
			// if cache expired or non-existent, get latest
			$posts = $this->Post->find('latest');
		}

		// get cached upcoming events, if expired find the upcoming
		$events = Cache::read('upcoming_events');
		if ($events === false) {
			// if cache expired or non-existent, get upcoming
			$events = $this->Event->find('upcoming');
		}

		$this->set('title_for_layout', 'Home');
		$this->set(compact('posts', 'events'));
		$this->set('mainpage', $this->Page->find('first', array('conditions' => array('Page.main' => 1))));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($slug = null) {
		$this->Page->recursive = -1;
		if (!$slug) {
			throw new NotFoundException('Invalid Page.');
		}
		$page = $this->Page->findBySlug($slug);
		if (!$page) {
			throw new NotFoundException('Invalid Page.');
		}
		if (!$page['Page']['published']) {
			throw new NotFoundException('Invalid Page.');
		}
		$this->set('title_for_layout', $page['Page']['title']);
		$this->set(compact('page'));
		$this->Page->PageSection->recursive = -1;
		$this->set('pageSections', $this->paginate('PageSection', array('PageSection.page_id' => $page['Page']['id'], 'PageSection.section >' => 0)));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';
		$this->Page->recursive = 0;
		$this->set('title_for_layout', 'Pages');
		$this->set('pages', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException('Invalid Page.');
		}
		$page = $this->Page->find('first', array('conditions' => array('Page.id' => $id)));
		$this->set(compact('page'));
		$this->set('title_for_layout', 'Page: '.$page['Page']['title']);
		$this->set('images', $this->Page->listFiles($page['Page']['id']));
	}

/**
 * admin_add method
 *
 * Saves a new page and its sections. In order to use a non-
 * transactional DB (like MySQL ISAM tables), associated data (page
 * sections) is not saved atomically (in one transaction) and the
 * page_id field of each section is not validated.
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'default_admin';
		if ($this->request->is('post')) {
			$this->Page->create();
			// do not validate page_id of the page sections
			unset($this->Page->PageSection->validate['page_id']);
			// save associated data non-atomically since we're nor using transactions
			if ($this->Page->saveAssociated($this->request->data, array('atomic' => false))) {
				$this->Session->setFlash('The Page has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Page could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
			}
		}
		$this->set('title_for_layout', 'Add Page');
	}

/**
 * admin_edit method
 *
 * Edit a page with the possibility of uploading one image at a time.
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->layout = 'default_admin';
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException('Invalid Page.');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Page->save($this->request->data)) {
				$this->Upload->uploadImageThumb('img'.DS.'pages'.DS.sprintf("%010d", $id), $this->request->data['File']['image']);
				$this->Session->setFlash('The Page has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Page could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
			}
		} else {
			$this->request->data = $this->Page->read(null, $id);
		}
		$pageSections = $this->Page->PageSection->find('all', array('conditions' => array('Page.id' => $id)));
		$this->set('title_for_layout', 'Edit Page');
		$this->set(compact('pageSections'));
		$this->set('images', $this->Page->listFiles($id));
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
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException('Invalid Page.');
		}
		if ($this->Page->delete()) {
			$this->Session->setFlash('Page deleted.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Page was not deleted.', 'default', array('class' => 'alert alert-error'));
		$this->redirect(array('action' => 'admin_index'));
	}

/**
 * admin_deleteFile method
 *
 * Delete one image file of a page.
 *
 * @param string $id
 * @param string $filename
 * @return void
 */
	public function admin_deleteFile($id = null, $filename = null) {
		$this->layout = 'default_admin';
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException('Invalid Page.');
		}
		if (!$filename) {
			throw new NotFoundException('Invalid Image.');
		}
		if ($this->Page->deleteFile($id, $filename)) {
			$this->Session->setFlash('File deleted.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'admin_view', $id));
		}
		$this->Session->setFlash('File was not deleted.', 'default', array('class' => 'alert alert-error'));
		$this->redirect(array('action' => 'admin_view', $id));
	}

}
