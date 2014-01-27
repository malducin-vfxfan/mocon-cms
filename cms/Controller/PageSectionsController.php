<?php
/**
 * Page Sections controller.
 *
 * Page Sections actions.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Controller.PageSections
 */
App::uses('AppController', 'Controller');
/**
 * PageSections Controller
 *
 * @property PageSection $PageSection
 */
class PageSectionsController extends AppController {

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
		$this->set('title_for_layout', 'Page Sections');

		$this->Paginator->settings = array('recursive' => 0);
		$this->set('pageSections', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		if (!$this->PageSection->exists($id)) {
			throw new NotFoundException('Invalid Page Section.');
		}
		$options = array('conditions' => array('PageSection.id' => $id));
		$pageSection = $this->PageSection->find('first', $options);
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
			if ($this->PageSection->save($this->request->data)) {
				$options = array('conditions' => array('PageSection.id' => $this->PageSection->id));
				$pageSection = $this->PageSection->find('first', $options);
				$this->Session->setFlash('The Page Section has been saved.', 'Flash/success');
				return $this->redirect(array('controller' => 'pages', 'action' => 'admin_view', $pageSection['PageSection']['page_id']));
			} else {
				$this->Session->setFlash('The Page Section could not be saved. Please, try again.', 'Flash/error');
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
		if (!$this->PageSection->exists($id)) {
			throw new NotFoundException('Invalid Page Section.');
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PageSection->save($this->request->data)) {
				$options = array('conditions' => array('PageSection.id' => $this->PageSection->id));
				$pageSection = $this->PageSection->find('first', $options);
				$this->Session->setFlash('The Page Section has been saved.', 'Flash/success');
				return $this->redirect(array('controller' => 'pages', 'action' => 'admin_view', $pageSection['PageSection']['page_id']));
			} else {
				$this->Session->setFlash('The Page Section could not be saved. Please, try again.', 'Flash/error');
			}
		} else {
			$options = array('conditions' => array('PageSection.id' => $id));
			$this->request->data = $this->PageSection->find('first', $options);
		}
		$pages = $this->PageSection->Page->find('list');
		$this->set('title_for_layout', 'Edit Page Section');
		$this->set(compact('pages'));
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

		$this->PageSection->id = $id;
		if (!$this->PageSection->exists($id)) {
			throw new NotFoundException('Invalid Page Section.');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->PageSection->delete()) {
			$this->Session->setFlash('Page Section deleted.', 'Flash/success');
			return $this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Page Section was not deleted.', 'Flash/error');
		return $this->redirect(array('action' => 'admin_index'));
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
