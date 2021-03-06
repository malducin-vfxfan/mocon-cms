<?php
/**
 * Posts controller.
 *
 * Posts actions.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.Controller.Posts
 */
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 * @property RequestHandler $RequestHandler
 * @property UploadComponent $Upload
 */
class PostsController extends AppController
{

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
 * beforeFilter method
 *
 * @return void
 */
    public function beforeFilter()
    {
        parent::beforeFilter();

        $this->Security->unlockedActions = array('admin_ajaxUploadFiles');
    }

/**
 * index method
 *
 * @return void
 */
    public function index()
    {
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
    public function view($slug = null)
    {
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
    public function admin_index()
    {
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
    public function admin_view($id = null)
    {
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
    public function admin_add()
    {
        $this->layout = 'default_admin';
        if ($this->request->is('post')) {
            $this->Post->create();
            $this->request->data['Post']['user_id'] = $this->Auth->user('id');
            if ($this->Post->save($this->request->data)) {
                $options = array('conditions' => array('Post.id' => $this->Post->id));
                $post = $this->Post->find('first', $options);
                if ($post) {
                    $this->Upload->uploadFile('img'.DS.'posts'.DS.$post['Post']['year'].DS.sprintf("%010d", $this->Post->id), $this->request->data['File']['image'], $this->Upload->convertFilenameToId($this->Post->id, $this->request->data['File']['image']['name']), array('thumbs_folder' => false, 'responsive_images' => true));
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
    public function admin_edit($id = null)
    {
        $this->layout = 'default_admin';
        if (!$this->Post->exists($id)) {
            throw new NotFoundException('Invalid Post.');
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Post->save($this->request->data)) {
                $options = array('conditions' => array('Post.id' => $this->Post->id));
                $post = $this->Post->find('first', $options);
                if ($post) {
                    $this->Upload->uploadFile('img'.DS.'posts'.DS.$post['Post']['year'].DS.sprintf("%010d", $this->Post->id), $this->request->data['File']['image'], $this->Upload->convertFilenameToId($this->Post->id, $this->request->data['File']['image']['name']), array('thumbs_folder' => false, 'responsive_images' => true));
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
    public function admin_delete($id = null)
    {
        $this->layout = 'default_admin';

        $this->Post->id = $id;
        if (!$this->Post->exists()) {
            throw new NotFoundException('Invalid Post.');
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Post->delete()) {
            $this->Session->setFlash('Post deleted.', 'Flash/success');
            return $this->redirect(array('action' => 'admin_index'));
        }
        $this->Session->setFlash('Post was not deleted.', 'Flash/error');
        return $this->redirect(array('action' => 'admin_index'));
    }

/**
 * admin_deleteFile method
 *
 * Delete one image file of a post.
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
    public function admin_deleteFile($id = null)
    {
        $this->autoRender = false;

        $filename = $this->request->query('filename');

        if (empty($id) || empty($filename)) {
            $this->Session->setFlash('Invalid Post or image.', 'Flash/error');
            return $this->redirect(array('action' => 'admin_index'));
        }

        if (!$this->Post->exists($id)) {
            throw new NotFoundException('Invalid Post.');
        }

        $this->request->allowMethod('post', 'delete');

        $options = array('conditions' => array('Post.id' => $id));
        $post = $this->Post->find('first', $options);

        if ($post) {
            $path = WWW_ROOT.'img'.DS.'posts'.DS.$post['Post']['year'].DS.sprintf("%010d", $post['Post']['id']).DS.$filename;
            $result = $this->Post->deleteFile($path);
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
    public function admin_ajaxUploadFiles($id = null, $uploadType = 'images')
    {
        $this->autoRender = false;

        if (empty($id)) {
            $this->response->statusCode(404);
            return false;
        }

        $options = json_decode($this->request->data['options']);

        if ($this->request->is(array('post'))) {
            switch ($uploadType) {
                case 'preview-images':
                    $this->Upload->uploadFiles('img'.DS.'posts'.DS.$options->{'year'}.DS.sprintf("%010d", $id), $this->request->form);
                    break;
            }

            $this->response->statusCode(200);
            return true;
        }
    }

}
