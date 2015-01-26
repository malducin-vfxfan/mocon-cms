<?php
/**
 * Albums controller.
 *
 * Albums actions. Can upload and delete album images at a time,
 * though FTP would be faster.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Controller.Albums
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
 * beforeFilter method
 *
 * Disable fields for multiple image uploads.
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		if ($this->request->action == 'admin_add' || $this->request->action == 'admin_edit') {
			$unlocked_fields = array();

			$unlocked_fields[] = 'File.image';

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
		$this->set('title_for_layout', 'Albums');

		$this->Paginator->settings = array('recursive' => 0);
		$this->set('albums', $this->Paginator->paginate());
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

		$this->Paginator->settings = array(
			'conditions' => array('folder' => WWW_ROOT.'img'.DS.'albums'.DS.$album['Album']['year'].DS.sprintf('%010d', $album['Album']['id'])),
			'limit' => 60
		);

		$this->set(compact('album'));
		$this->set('albumImages', $this->Paginator->paginate('AlbumImage'));
		$this->set('title_for_layout', 'Album: '.$album['Album']['name']);
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';
		$this->set('title_for_layout', 'Albums');

		$this->Paginator->settings = array('recursive' => -1);
		$this->set('albums', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		if (!$this->Album->exists($id)) {
			throw new NotFoundException('Invalid Album.');
		}
		$options = array('conditions' => array('Album.id' => $id));
		$album = $this->Album->find('first', $options);
		$images = $this->Album->getAlbumThumbnails($album['Album']['id'], $album['Album']['year']);
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
				$options = array('conditions' => array('Album.id' => $this->Album->id));
				$album = $this->Album->find('first', $options);
				if ($album) {
					$this->Upload->uploadFile('img'.DS.'albums'.DS.$album['Album']['year'].DS.sprintf("%010d", $this->Album->id).DS.'preview', $this->request->data['File']['preview_image'], $this->Upload->convertFilenameToId($this->Album->id, $this->request->data['File']['preview_image']['name']), array('thumbs_folder' => false, 'responsive_images' => true));
					$this->Upload->uploadFiles('img'.DS.'albums'.DS.$album['Album']['year'].DS.sprintf("%010d", $this->Album->id), $this->request->data['File']['image'], null, array('create_thumb' => true));
				}
				$this->Session->setFlash('The Album has been saved.', 'Flash/success');
				return $this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Album could not be saved. Please, try again.', 'Flash/error');
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
		if (!$this->Album->exists($id)) {
			throw new NotFoundException('Invalid Album.');
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Album->save($this->request->data)) {
				$options = array('conditions' => array('Album.id' => $this->Album->id));
				$album = $this->Album->find('first', $options);
				if ($album) {
					$this->Upload->uploadFile('img'.DS.'albums'.DS.$album['Album']['year'].DS.sprintf("%010d", $this->Album->id).DS.'preview', $this->request->data['File']['preview_image'], $this->Upload->convertFilenameToId($this->Album->id, $this->request->data['File']['preview_image']['name']), array('thumbs_folder' => false, 'responsive_images' => true));
					$this->Upload->uploadFiles('img'.DS.'albums'.DS.$album['Album']['year'].DS.sprintf("%010d", $this->Album->id), $this->request->data['File']['image'], null, array('create_thumb' => true));
				}
				$this->Session->setFlash('The Album has been saved.', 'Flash/success');
				return $this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Album could not be saved. Please, try again.', 'Flash/error');
			}
		} else {
			$options = array('conditions' => array('Album.id' => $id));
			$this->request->data = $this->Album->find('first', $options);
		}
		$this->set('title_for_layout', 'Edit Album');
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

		$this->Album->id = $id;
		if (!$this->Album->exists()) {
			throw new NotFoundException('Invalid Album.');
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Album->delete()) {
			$this->Session->setFlash('Album deleted.', 'Flash/success');
			return $this->redirect(array('action' => 'admin_index'));
		}
		$this->Session->setFlash('Album was not deleted.', 'Flash/error');
		return $this->redirect(array('action' => 'admin_index'));
	}

/**
 * admin_deleteAlbumImage method
 *
 * Delete one album image and its thumbnail.
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_deleteAlbumImage($id = null, $image = null) {
		$this->layout = 'default_admin';

		if (!$id or !$image) {
			$this->Session->setFlash('Invalid Album or image.', 'Flash/error');
			return $this->redirect(array('action' => 'admin_index'));
		}

		if (!$this->Album->exists($id)) {
			throw new NotFoundException('Invalid Album.');
		}

		$this->request->allowMethod('post', 'delete');
		if ($this->Album->deleteFile($id, $image)) {
			$this->Session->setFlash('Album image deleted.', 'Flash/success');
			return $this->redirect(array('action' => 'admin_view', $id));
		}
		$this->Session->setFlash('There was a problem deleting the Album image.', 'Flash/success');
		return $this->redirect(array('action' => 'admin_view', $id));
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
	public function admin_ajaxUploadFiles($id = null, $uploadType = 'preview-images') {
		$this->autoRender = false;

		if (empty($id)) {
			$this->response->statusCode(404);
			return false;
		}

		$options = json_decode($this->request->data['options']);

		if ($this->request->is(array('post'))) {
			switch ($uploadType) {
				case 'preview-images':
					$this->Upload->uploadFiles('img'.DS.'albums'.DS.$options->{'year'}.DS.sprintf("%010d", $id).DS.'preview', $this->request->form);
					break;
				case 'album':
					$this->Upload->uploadFiles('img'.DS.'albums'.DS.$options->{'year'}.DS.sprintf("%010d", $id), $this->request->form);
					break;
				case 'album-thumbnails':
					$this->Upload->uploadFiles('img'.DS.'albums'.DS.$options->{'year'}.DS.sprintf("%010d", $id).DS.'thumbnails', $this->request->form);
					break;
			}

			$this->response->statusCode(200);
			return true;
		}
	}

}
