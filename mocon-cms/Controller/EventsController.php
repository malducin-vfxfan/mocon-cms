<?php
/**
 * Events controller.
 *
 * Events actions.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.Controller.Events
 */
App::uses('AppController', 'Controller');
/**
 * Events Controller
 *
 * @property Event $Event
 * @property UploadComponent $Upload
 */
class EventsController extends AppController
{

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
 * @return void
 */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('archive');

        $this->Security->unlockedActions = array('admin_ajaxUploadFiles');
    }

/**
 * index method
 *
 * @return void
 */
    public function index()
    {
        $this->set('title_for_layout', 'Upcoming Events');

        $this->Paginator->settings = array(
            'conditions' => array('Event.date_end >= CURDATE()'),
            'recursive' => 0
        );
        $this->set('events', $this->Paginator->paginate());
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
            throw new NotFoundException('Invalid Event.');
        }
        $event = $this->Event->findBySlug($slug);
        if (!$event) {
            throw new NotFoundException('Invalid Event.');
        }
        $this->set(compact('event'));
        $this->set('title_for_layout', 'Event: '.$event['Event']['name']);
    }

/**
 * archive method
 *
 * @return void
 */
    public function archive()
    {
        $this->set('title_for_layout', 'Past Events');

        $this->Paginator->settings = array(
            'conditions' => array('Event.date_end <' => date('Y-m-d')),
            'order' => array('Event.date_start' => 'DESC'),
            'recursive' => 0
        );
        $this->set('events', $this->Paginator->paginate());
    }

/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index()
    {
        $this->layout = 'default_admin';
        $this->set('title_for_layout', 'Events');

        $this->Paginator->settings = array(
            'order' => array('Event.date_start' => 'DESC'),
            'recursive' => 0
        );
        $this->set('events', $this->Paginator->paginate());
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
        if (!$this->Event->exists($id)) {
            throw new NotFoundException('Invalid Event.');
        }
        $options = array('conditions' => array('Event.id' => $id));
        $event = $this->Event->find('first', $options);
        $this->set(compact('event'));
        $this->set('title_for_layout', 'Event: ');
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
            $this->Event->create();
            if ($this->Event->save($this->request->data)) {
                $options = array('conditions' => array('Event.id' => $this->Event->id));
                $event = $this->Event->find('first', $options);
                if ($event) {
                    $this->Upload->uploadFile('img'.DS.'events'.DS.$event['Event']['year'].DS.sprintf("%010d", $this->Event->id), $this->request->data['File']['image'], $this->Upload->convertFilenameToId($this->Event->id, $this->request->data['File']['image']['name']), array('thumbs_folder' => false, 'responsive_images' => true));
                }
                $this->Session->setFlash('The Event has been saved.', 'Flash/success');
                return $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->Session->setFlash('The Event could not be saved. Please, try again.', 'Flash/error');
            }
        }
        $this->set('title_for_layout', 'Add Event');
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
        if (!$this->Event->exists($id)) {
            throw new NotFoundException('Invalid Event.');
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Event->save($this->request->data)) {
                $options = array('conditions' => array('Event.id' => $this->Event->id));
                $event = $this->Event->find('first', $options);
                if ($event) {
                    $this->Upload->uploadFile('img'.DS.'events'.DS.$event['Event']['year'].DS.sprintf("%010d", $this->Event->id), $this->request->data['File']['image'], $this->Upload->convertFilenameToId($this->Event->id, $this->request->data['File']['image']['name']), array('thumbs_folder' => false, 'responsive_images' => true));
                }
                $this->Session->setFlash('The Event has been saved.', 'Flash/success');
                return $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->Session->setFlash('The Event could not be saved. Please, try again.', 'Flash/error');
            }
        } else {
            $options = array('conditions' => array('Event.id' => $id));
            $this->request->data = $this->Event->find('first', $options);
        }
        $this->set('title_for_layout', 'Edit Event');
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

        $this->Event->id = $id;
        if (!$this->Event->exists()) {
            throw new NotFoundException('Invalid Event.');
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Event->delete()) {
            $this->Session->setFlash('Event deleted.', 'Flash/success');
            return $this->redirect(array('action' => 'admin_index'));
        }
        $this->Session->setFlash('Event was not deleted.', 'Flash/error');
        return $this->redirect(array('action' => 'admin_index'));
    }

/**
 * admin_deleteFile method
 *
 * Delete one image file of an event.
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
            $this->Session->setFlash('Invalid Event or image.', 'Flash/error');
            return $this->redirect(array('action' => 'admin_index'));
        }

        if (!$this->Event->exists($id)) {
            throw new NotFoundException('Invalid Event.');
        }

        $this->request->allowMethod('post', 'delete');

        $options = array('conditions' => array('Event.id' => $id));
        $event = $this->Event->find('first', $options);

        if ($event) {
            $path = WWW_ROOT.'img'.DS.'events'.DS.$event['Event']['year'].DS.sprintf("%010d", $event['Event']['id']).DS.$filename;
            $result = $this->Event->deleteFile($path);
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
                    $this->Upload->uploadFiles('img'.DS.'events'.DS.$options->{'year'}.DS.sprintf("%010d", $id), $this->request->form);
                    break;
            }

            $this->response->statusCode(200);
            return true;
        }
    }

}
