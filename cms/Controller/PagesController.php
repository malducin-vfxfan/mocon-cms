<?php
/**
 * Pages controller.
 *
 * Pages actions. Can save related page sections during the creation
 * of a new page, but validation of extra sections is skipped. Also
 * upload page images one at a time and delete them.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Controller.Pages
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

		if ($this->request->action === 'admin_add' || $this->request->action === 'admin_edit') {
			$unlocked_fields = array();
			for ($i = 1; $i < 6; $i++) {
				$unlocked_fields[] = 'PageSection.'.$i.'.title';
				$unlocked_fields[] = 'PageSection.'.$i.'.section';
				$unlocked_fields[] = 'PageSection.'.$i.'.content';
			}

			$unlocked_fields[] = 'File.image';
			$unlocked_fields[] = 'File.document';

			$this->Security->unlockedFields = $unlocked_fields;
		}

		$this->Security->unlockedActions = array('admin_ajaxUploadFiles');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
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
		if (!$slug) {
			throw new NotFoundException('Invalid Page.');
		}
		$this->Page->recursive = -1;
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
			'limit' => 1,
			'recursive' => -1
		);
		$this->set('pageSections', $this->Paginator->paginate('PageSection'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';
		$this->set('title_for_layout', 'Pages');

		$this->Paginator->settings = array('recursive' => 0);
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
		$this->set('images', $this->Page->listFiles($page['Page']['id'], WWW_ROOT.'img'));
		$this->set('documents', $this->Page->listFiles($page['Page']['id'], WWW_ROOT.'files'));
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
				$this->Upload->uploadFiles('img'.DS.'pages'.DS.sprintf("%010d", $this->Page->id), $this->request->data['File']['image']);
				$this->Upload->uploadFiles('files'.DS.'pages'.DS.sprintf("%010d", $this->Page->id), $this->request->data['File']['document'], null, array('file_types' => array('application/pdf')));

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
				$this->Upload->uploadFiles('img'.DS.'pages'.DS.sprintf("%010d", $id), $this->request->data['File']['image']);
				$this->Upload->uploadFiles('files'.DS.'pages'.DS.sprintf("%010d", $id), $this->request->data['File']['document'], null, array('file_types' => array('application/pdf')));

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
		$this->set('images', $this->Page->listFiles($id, WWW_ROOT.'img'));
		$this->set('documents', $this->Page->listFiles($id, WWW_ROOT.'files'));
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

		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException('Invalid Page.');
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Page->delete()) {
			$this->Session->setFlash('Page deleted.', 'Flash/success');
			return $this->redirect(array('action' => 'admin_index'));
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
 * @return void
 */
	public function admin_deleteFile($id = null) {
		$this->autoRender = false;

		$filename = $this->request->query('filename');

		if (empty($id) || empty($filename)) {
			$this->Session->setFlash('Invalid Page or image.', 'Flash/error');
			return $this->redirect(array('action' => 'admin_index'));
		}

		if (!$this->Page->exists($id)) {
			throw new NotFoundException('Invalid Page.');
		}

		$this->request->allowMethod('post', 'delete');

		$options = array('conditions' => array('Page.id' => $id));
		$page = $this->Page->find('first', $options);

		if ($page) {
			switch ($this->request->query('fileType')) {
				case 'image':
					$path = WWW_ROOT.'img'.DS.'pages'.DS.sprintf("%010d", $page['Page']['id']).DS.$filename;
					$result = $this->Page->deleteFile($path);
					break;

				case 'file':
					$path = WWW_ROOT.'files'.DS.'pages'.DS.sprintf("%010d", $page['Page']['id']).DS.$filename;
					$result = $this->Page->deleteFile($path);
					break;

			}
		}

		if ($result) {
			$this->Session->setFlash('File deleted.', 'Flash/success');
		} else {
			$this->Session->setFlash('File was not deleted.', 'Flash/error');
		}

		$redirection = $this->request->query('redirection');
		if (!$redirection) {
			return $this->redirect(array('action' => 'admin_index'));
		} else {
			return $this->redirect(array('action' => $redirection, $id));
		}
	}

/**
 * admin_ajaxUploadFiles method
 *
 * Upload files via AJAX.
 *
 * @param string $id
 * @param string $uploadType
 * @return void
 */
	public function admin_ajaxUploadFiles($id = null, $uploadType = 'images') {
		$this->autoRender = false;

		if (empty($id)) {
			$this->response->statusCode(404);
			return false;
		}

		if ($this->request->is(array('post'))) {
			switch ($uploadType) {
				case 'images':
					$this->Upload->uploadFiles('img'.DS.'pages'.DS.sprintf("%010d", $id), $this->request->form);
					break;
				case 'files':
					$this->Upload->uploadFiles('files'.DS.'pages'.DS.sprintf("%010d", $id), $this->request->form, null, array('file_types' => array('application/pdf')));
					break;
			}

			$this->response->statusCode(200);
			return true;
		}
	}
}
