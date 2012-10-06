<?php
/**
 * Page Sections controller.
 *
 * Page Sections actions.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       page_sections
 * @subpackage    page_sections.controller
 */
App::uses('AppController', 'Controller');
/**
 * PageSections Controller
 *
 * @property PageSection $PageSection
 * @property BritaComponent $Brita
 */
class PageSectionsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Brita');

/**
 * beforeFilter method
 *
 * Enable the TinyMCE image list method.
 *
 * @return void
 */
 	public function beforeFilter() {
 		parent::beforeFilter();
 		$this->Security->requireAuth(array('admin_tinymceImageList'));
 	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';
		$this->PageSection->recursive = 0;
		$this->set('title_for_layout', 'Page Sections');
		$this->set('pageSections', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		$this->PageSection->id = $id;
		if (!$this->PageSection->exists()) {
			throw new NotFoundException('Invalid Page Section.');
		}
		$pageSection = $this->PageSection->find('first', array('conditions' => array('PageSection.id' => $id)));
		$this->set(compact('pageSection'));
		$this->set('title_for_layout', 'Page Section: '.$pageSection['PageSection']['title']);
		$this->set('images', $this->PageSection->listFiles($pageSection['PageSection']['page_id']));
		$this->set('documents', $this->PageSection->listFiles($pageSection['PageSection']['page_id'], FILES));
	}

/**
 * admin_add method
 *
 * @param string $page_id
 * @return void
 */
	public function admin_add($page_id = null) {
		$this->layout = 'default_admin';
		if ($this->request->is('post')) {
			$this->PageSection->create();
			$this->request->data['PageSection']['content'] = $this->brita->purify($this->request->data['PageSection']['content']);
			if ($this->PageSection->save($this->request->data)) {
				$pageSection = $this->PageSection->find('first', array('conditions' => array('PageSection.id' => $this->PageSection->id)));
				$this->Session->setFlash('The Page Section has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('controller' => 'pages', 'action' => 'admin_view', $pageSection['PageSection']['page_id']));
			} else {
				$this->Session->setFlash('The Page Section could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
			}
		}
		$pages = $this->PageSection->Page->find('list');
		$this->set('title_for_layout', 'Add Page Section');
		$this->set(compact('pages'));
		$this->set('selected', $page_id);
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->layout = 'default_admin';
		$this->PageSection->id = $id;
		if (!$this->PageSection->exists()) {
			throw new NotFoundException('Invalid Page Section.');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['PageSection']['content'] = $this->brita->purify($this->request->data['PageSection']['content']);
			if ($this->PageSection->save($this->request->data)) {
				$pageSection = $this->PageSection->find('first', array('conditions' => array('PageSection.id' => $this->PageSection->id)));
				$this->Session->setFlash('The Page Section has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('controller' => 'pages', 'action' => 'admin_view', $pageSection['PageSection']['page_id']));
			} else {
				$this->Session->setFlash('The Page Section could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
			}
		} else {
			$this->request->data = $this->PageSection->read(null, $id);
		}
		$pages = $this->PageSection->Page->find('list');
		$this->set('title_for_layout', 'Edit Page Section');
		$this->set(compact('pages'));
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
		$this->PageSection->id = $id;
		if (!$this->PageSection->exists()) {
			throw new NotFoundException('Invalid Page Section.');
		}
		if ($this->PageSection->delete()) {
			$this->Session->setFlash('Page Section deleted.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Page Section was not deleted.', 'default', array('class' => 'alert alert-error'));
		$this->redirect(array('action' => 'admin_index'));
	}

/**
 * admin_tinymceImageList method
 *
 * Generate a list of image files of a page to be displayed in the
 * TinyMCE editor image chooser if it's being used.
 *
 * @param string $id
 * @return mixed
 */
	public function admin_tinymceImageList($id = null) {
		$this->layout = 'ajax';

		 if (!$id) return;

		$images = $this->PageSection->listFiles($id);
		$this->set(compact('images'));
		$this->set('page_id', $id);
	}

}
