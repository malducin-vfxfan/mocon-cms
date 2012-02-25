<?php
/**
 * Posts controller.
 *
 * Posts actions.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       posts
 * @subpackage    posts.controller
 */
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 */
class PostsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Brita', 'RequestHandler', 'Upload');
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
		$this->Post->recursive = 0;
		if ($this->RequestHandler->isRss()) {
			// get cached results
			$posts = Cache::read('latest_posts');
			if ($posts === false) {
				// if cache expired or non-existent, get latest
				$posts = $this->Post->find('latest');
			}
			$this->set(compact('posts'));
		}
		else {
			$this->set('title_for_layout', 'Posts');
			$this->set('posts', $this->paginate());
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
		$this->Post->recursive = 0;
		$this->set('title_for_layout', 'Posts');
		$this->set('posts', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException('Invalid Post.');
		}
		$post = $this->Post->find('first', array('conditions' => array('Post.id' => $id)));
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
			$this->request->data['Post']['content'] = $this->brita->purify($this->request->data['Post']['content']);
			if ($this->Post->save($this->request->data)) {
				$post = $this->Post->find('first', array('conditions' => array('Post.id' => $this->Post->id)));
				$this->Upload->uploadImageThumb('img'.DS.'posts'.DS.$post['Post']['year'], $this->request->data['File']['image'], $this->Upload->convertFilenameToId($this->Post->id, $this->request->data['File']['image']['name']));
				$this->Session->setFlash('The Post has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Post could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
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
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException('Invalid Post.');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Post->save($this->request->data)) {
				$post = $this->Post->find('first', array('conditions' => array('Post.id' => $this->Post->id)));
				$this->Upload->uploadImageThumb('img'.DS.'posts'.DS.$post['Post']['year'], $this->request->data['File']['image'], $this->Upload->convertFilenameToId($this->Post->id, $this->request->data['File']['image']['name']));
				$this->Session->setFlash('The Post has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Post could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
			}
		} else {
			$this->request->data = $this->Post->read(null, $id);
		}
		$this->set('title_for_layout', 'Edit Post');
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
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException('Invalid Post.');
		}
		if ($this->Post->delete()) {
			$this->Session->setFlash('Post deleted.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Post was not deleted.', 'default', array('class' => 'alert alert-error'));
		$this->redirect(array('action' => 'admin_index'));
	}
}
