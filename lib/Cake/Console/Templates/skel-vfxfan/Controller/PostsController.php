<?php
/**
 * Posts controller.
 *
 * Posts controller.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    posts
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
	var $components = array('Brita', 'RequestHandler', 'Upload');
/**
 * Helpers
 *
 * @var array
 */
	var $helpers = array('FormatImage', 'Rss');

/**
 * beforeFilter method
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('latest_posts');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Post->recursive = 0;
		if ($this->RequestHandler->isRss()) {
			$posts = $this->Post->getLatest(5);
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
 * latest_posts method
 *
 * @param int $num_posts
 * @return array
 */
	public function latest_posts($num_posts = 5) {
		$posts = $this->Post->getLatest($num_posts);
		return $posts;
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
		$post = $this->Post->read(null, $id);
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
			$this->data['Post']['user_id'] = $this->Auth->user('id');
			$this->data['Post']['content'] = $this->brita->purify($this->data['Post']['content']);
			if ($this->Post->save($this->request->data)) {
				$this->Upload->uploadImageThumb('img'.DS.'posts', $this->data['File']['image'], $this->Upload->convertFilenameToId($this->Post->id, $this->data['File']['image']['name']));
				$this->Session->setFlash('The Post has been saved.', 'default', array('class' => 'message success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Post could not be saved. Please, try again.', 'default', array('class' => 'message failure'));
			}
		}
		$users = $this->Post->User->find('list');
		$this->set('title_for_layout', 'Add Post');
		$this->set(compact('users'));
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
				$this->Upload->uploadImageThumb('img'.DS.'posts', $this->data['File']['image'], $this->Upload->convertFilenameToId($this->Post->id, $this->data['File']['image']['name']));
				$this->Session->setFlash('The Post has been saved.', 'default', array('class' => 'message success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Post could not be saved. Please, try again.', 'default', array('class' => 'message failure'));
			}
		} else {
			$this->request->data = $this->Post->read(null, $id);
		}
		$users = $this->Post->User->find('list');
		$this->set('title_for_layout', 'Edit Post');
		$this->set(compact('users'));
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
			$this->Session->setFlash('Post deleted.', 'default', array('class' => 'message success'));
			$this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Post was not deleted.', 'default', array('class' => 'message failure'));
		$this->redirect(array('action' => 'admin_index'));
	}
}
