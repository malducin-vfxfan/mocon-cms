<?php
/**
 * Albums controller.
 *
 * Albums actions. Can upload and delete album images at a time,
 * though FTP would be faster.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       albums
 * @subpackage    albums.controller
 */
App::uses('AppController', 'Controller');
/**
 * Albums Controller
 *
 * @property Album $Album
 * @property UploadComponent $Upload
 */
class AlbumsController extends AppController {

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
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Album->recursive = 0;
		$this->set('title_for_layout', 'Albums');
		$this->set('albums', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($slug = null) {
		if (!$slug) {
			throw new NotFoundException('Invalid Album.');
		}
		$album = $this->Album->findBySlug($slug);
		if (!$album) {
			throw new NotFoundException('Invalid Album.');
		}
		$images = $this->Album->getAlbumThumbnails($album['Album']['id']);
		$this->set(compact('album', 'images'));
		$this->set('title_for_layout', 'Album: '.$album['Album']['name']);
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';
		$this->Album->recursive = -1;
		$this->set('title_for_layout', 'Albums');
		$this->set('albums', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		$this->Album->id = $id;
		if (!$this->Album->exists()) {
			throw new NotFoundException('Invalid Album.');
		}
		$album = $this->Album->read(null, $id);
		$images = $this->Album->getAlbumThumbnails($album['Album']['id']);
		$this->set(compact('album', 'images'));
		$this->set('title_for_layout', 'Album: '.$album['Album']['name']);

	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'default_admin';
		if ($this->request->is('post')) {
			$this->Album->create();
			if ($this->Album->save($this->request->data)) {
				$this->Upload->uploadImageThumb('img'.DS.'albums', $this->request->data['File']['image'], $this->Upload->convertFilenameToId($this->Album->id, $this->request->data['File']['image']['name']));
				$this->Session->setFlash('The Album has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Album could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
			}
		}
		$this->set('title_for_layout', 'Add Album');
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->layout = 'default_admin';
		$this->Album->id = $id;
		if (!$this->Album->exists()) {
			throw new NotFoundException('Invalid Album.');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Album->save($this->request->data)) {
				$this->Upload->uploadImageThumb('img'.DS.'albums', $this->request->data['File']['image'], $this->Upload->convertFilenameToId($this->Album->id, $this->request->data['File']['image']['name']));
				$this->Session->setFlash('The Album has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Album could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
			}
		} else {
			$this->request->data = $this->Album->read(null, $id);
		}
		$this->set('title_for_layout', 'Edit Album');
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
		$this->Album->id = $id;
		if (!$this->Album->exists()) {
			throw new NotFoundException('Invalid Album.');
		}
		if ($this->Album->delete()) {
			$this->Session->setFlash('Album deleted.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Album was not deleted.', 'default', array('class' => 'alert alert-error'));
		$this->redirect(array('action' => 'admin_index'));
	}

/**
 * admin_uploadAlbumImage method
 *
 * Upload one album image and create its thumbnail.
 *
 * @param string $id
 * @return void
 */
	public function admin_uploadAlbumImage($id = null) {
		$this->layout = 'default_admin';
		$this->Album->id = $id;
		if (!$this->Album->exists()) {
			throw new NotFoundException('Invalid Album.');
		}
		if ($this->request->is('post')) {
			$result = $this->Upload->uploadImageThumb('img'.DS.'albums'.DS.sprintf("%010d", $id), $this->request->data['File']['image'], $this->request->data['File']['image']['name'], array('create_thumb' => true));
			if ($result) {
				$this->Session->setFlash('The Album image has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_view', $id));
			}
			else {
				$this->Session->setFlash('The Album image could not be saved. Please, try again.', 'default', array('class' => 'alert alert-success'));
			}
		}
	}

/**
 * admin_deleteAlbumImage method
 *
 * Delete one album image and its thumbnail.
 *
 * @param string $id
 * @return void
 */
	public function admin_deleteAlbumImage($id = null, $image = null) {
		$this->layout = 'default_admin';

		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}

		if (!$id or !$image) {
			$this->Session->setFlash('Invalid Album or image.', 'default', array('class' => 'alert alert-error'));
			$this->redirect(array('action' => 'admin_index'));
		}

		$this->Album->id = $id;
		if (!$this->Album->exists()) {
			throw new NotFoundException('Invalid Album.');
		}

		if ($this->Album->deleteFile($id, $image)) {
			$this->Session->setFlash('Album image deleted.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action' => 'admin_view', $id));
		}
		$this->Session->setFlash('There was a problem deleting the Album image.', 'default', array('class' => 'alert alert-success'));
		$this->redirect(array('action' => 'admin_view', $id));
	}

}
