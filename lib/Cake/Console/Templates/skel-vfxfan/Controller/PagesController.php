<?php
/**
 * Pages controller.
 *
 * Pages actions. Can save related page sections during the creation
 * of a new page, but validation of extra sections is skipped. Also
 * upload page images one at a time and delete them.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Pages.Controller
 */
App::uses('AppController', 'Controller');
/**
 * Pages Controller
 *
 * @property Page $Page
 * @property UploadComponent $Upload
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
 * beforeFilter method
 *
 * Disable other page section fields from validation during creation
 * of new page. The for loop limit should match the maximum number of
 * possible page sections (established on the page forms script).
 *
 * This is done because other extra page sections are not part of the
 * original form, so they would normally be blackholed through
 * CakePHP's security.
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
		$options = array('conditions' => array('Page.main' => 1));
		$this->set('mainpage', $this->Page->find('first', $options));
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
		$this->Paginator->settings = array(
			'conditions' => array('PageSection.page_id' => $page['Page']['id'], 'PageSection.section >' => 0),
			'limit' => 1
		);
		$this->Page->PageSection->recursive = -1;
		$this->set('pageSections', $this->Paginator->paginate('PageSection'));
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
		$this->set('pages', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		if (!$this->Page->exists($id)) {
			throw new NotFoundException('Invalid Page.');
		}
		$options = array('conditions' => array('Page.id' => $id));
		$page = $this->Page->find('first', $options);
		$this->set(compact('page'));
		$this->set('title_for_layout', 'Page: '.$page['Page']['title']);
		$this->set('images', $this->Page->listFiles($page['Page']['id']));
		$this->set('documents', $this->Page->listFiles($page['Page']['id'], FILES));
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

			// save associated data non-atomically since we're not using transactions
			// also validate set to true so to validate each record before saving,
			// instead of trying to validate all records before any are saved, this
			// way the page is saved first and the page_id can be set for the extra
			// page sections
			$result = $this->Page->saveAssociated($this->request->data, array('atomic' => false, 'validate' => true));
			if ($result['Page']) {
				// check page sections
				$page_sections_ok = true;
				foreach ($result['PageSection'] as $result_page_section) {
					if (!$result_page_section) {
						$page_sections_ok = false;
						break;
					}
				}
				if ($page_sections_ok) {
					$this->Session->setFlash('The Page has been saved.', 'Flash/success');
				} else {
					$this->Session->setFlash('The Page has been saved, but there was a problem saving one or more sections.', 'default', array('class' => 'alert alert-info'));
				}
				return $this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Page could not be saved. Please, try again.', 'Flash/error');
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
		if (!$this->Page->exists($id)) {
			throw new NotFoundException('Invalid Page.');
		}
		if ($this->request->is(array('post', 'put'))) {
			// save associated data non-atomically since we're not using transactions
			$result = $this->Page->saveAssociated($this->request->data, array('atomic' => false));
			if ($result['Page']) {
				$this->Upload->uploadImageThumb('img'.DS.'pages'.DS.sprintf("%010d", $id), $this->request->data['File']['image']);
				$this->Upload->uploadFile('files'.DS.'pages'.DS.sprintf("%010d", $id), $this->request->data['File']['document']);

				// check page sections
				$page_sections_ok = true;
				foreach ($result['PageSection'] as $result_page_section) {
					if (!$result_page_section) {
						$page_sections_ok = false;
						break;
					}
				}
				if ($page_sections_ok) {
					$this->Session->setFlash('The Page has been saved.', 'Flash/success');
				} else {
					$this->Session->setFlash('The Page has been saved, but there was a problem saving one or more sections.', 'default', array('class' => 'alert alert-info'));
				}
				return $this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Page could not be saved. Please, try again.', 'Flash/error');
			}
		} else {
			$options = array('conditions' => array('Page.id' => $id));
			$this->request->data = $this->Page->find('first', $options);
		}
		$options = array('conditions' => array('Page.id' => $id));
		$pageSections = $this->Page->PageSection->find('all', $options);
		$this->set('title_for_layout', 'Edit Page');
		$this->set(compact('pageSections'));
		$this->set('images', $this->Page->listFiles($id));
		$this->set('documents', $this->Page->listFiles($id, FILES));
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
		if (!$this->Page->exists($id)) {
			throw new NotFoundException('Invalid Page.');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Page->delete()) {
			$this->Session->setFlash('Page deleted.', 'Flash/success');
			return $this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Page was not deleted.', 'Flash/error');
		return $this->redirect(array('action' => 'admin_index'));
	}

/**
 * admin_deleteFile method
 *
 * Delete one image file of a page.
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @param string $filename
 * @param string $location
 * @return void
 */
	public function admin_deleteFile($id = null, $filename = null, $location = 'images') {
		$this->layout = 'default_admin';
		if (!$this->Page->exists($id)) {
			throw new NotFoundException('Invalid Page.');
		}
		if (!$filename) {
			throw new NotFoundException('Invalid File.');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($location == 'images') {
			if ($this->Page->deleteFile($id, $filename)) {
				$this->Session->setFlash('File deleted.', 'Flash/success');
				return $this->redirect(array('action'=>'admin_view', $id));
			}
		}
		if ($location == 'files') {
			if ($this->Page->deleteFile($id, $filename, FILES)) {
				$this->Session->setFlash('File deleted.', 'Flash/success');
				return $this->redirect(array('action'=>'admin_view', $id));
			}
		}
		$this->Session->setFlash('File was not deleted.', 'Flash/error');
		return $this->redirect(array('action' => 'admin_view', $id));
	}

}
