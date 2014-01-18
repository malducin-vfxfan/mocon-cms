<?php
/**
 * Posts controller.
 *
 * Posts actions.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Posts.Controller
 */
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 * @property RequestHandler $RequestHandler
 * @property UploadComponent $Upload
 */
class PostsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('RequestHandler', 'Upload');
/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('FormatImage', 'Rss');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		if ($this->RequestHandler->isRss()) {
			// get cached results
			$posts = Cache::read('latest_posts');
			if ($posts === false) {
				// if cache expired or non-existent, get latest
				$posts = $this->Post->find('latest');
			}
			$this->set(compact('posts'));
		} else {
			$this->set('title_for_layout', 'Posts');

			$this->Paginator->settings = array('recursive' => 0);
			$this->set('posts', $this->Paginator->paginate());
		}
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($slug = null) {
		if (!$slug) {
			throw new NotFoundException('Invalid Post.');
		}
		$post = $this->Post->findBySlug($slug);
		if (!$post) {
			throw new NotFoundException('Invalid Post.');
		}
		$this->set(compact('post'));
		$this->set('title_for_layout', 'Post: '.$post['Post']['title']);
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';
		$this->set('title_for_layout', 'Posts');

		$this->Paginator->settings = array('recursive' => 0);
		$this->set('posts', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		if (!$this->Post->exists($id)) {
			throw new NotFoundException('Invalid Post.');
		}
		$options = array('conditions' => array('Post.id' => $id));
		$post = $this->Post->find('first', $options);
		$this->set(compact('post'));
		$this->set('title_for_layout', 'Post: '.$post['Post']['title']);
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'default_admin';
		if ($this->request->is('post')) {
			$this->Post->create();
			$this->request->data['Post']['user_id'] = $this->Auth->user('id');
			if ($this->Post->save($this->request->data)) {
				$options = array('conditions' => array('Post.id' => $this->Post->id));
				$post = $this->Post->find('first', $options);
				if ($post) {
					$this->Upload->uploadImageThumb('img'.DS.'posts'.DS.$post['Post']['year'], $this->request->data['File']['image'], $this->Upload->convertFilenameToId($this->Post->id, $this->request->data['File']['image']['name']));
				}
				$this->Session->setFlash('The Post has been saved.', 'Flash/success');
				return $this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Post could not be saved. Please, try again.', 'Flash/error');
			}
		}
		$this->set('title_for_layout', 'Add Post');
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->layout = 'default_admin';
		if (!$this->Post->exists($id)) {
			throw new NotFoundException('Invalid Post.');
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Post->save($this->request->data)) {
				$options = array('conditions' => array('Post.id' => $this->Post->id));
				$post = $this->Post->find('first', $options);
				if ($post) {
					$this->Upload->uploadImageThumb('img'.DS.'posts'.DS.$post['Post']['year'], $this->request->data['File']['image'], $this->Upload->convertFilenameToId($this->Post->id, $this->request->data['File']['image']['name']));
				}
				$this->Session->setFlash('The Post has been saved.', 'Flash/success');
				return $this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Post could not be saved. Please, try again.', 'Flash/error');
			}
		} else {
			$options = array('conditions' => array('Post.id' => $id));
			$this->request->data = $this->Post->find('first', $options);
		}
		$this->set('title_for_layout', 'Edit Post');
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
		if (!$this->Post->exists($id)) {
			throw new NotFoundException('Invalid Post.');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Post->delete()) {
			$this->Session->setFlash('Post deleted.', 'Flash/success');
			return $this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Post was not deleted.', 'Flash/error');
		return $this->redirect(array('action' => 'admin_index'));
	}
}
