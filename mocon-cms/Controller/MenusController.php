<?php
/**
 * Menus controller.
 *
 * Menus actions. Actually it handles menu items for one menu.
 * The root is assumed to have an id of 0, so all top level menu
 * items have a parent_id of 0. During add and edit operations this
 * root value is added to the list of available parent items.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.Controller.Menus
 */
App::uses('AppController', 'Controller');
/**
 * Menus Controller
 *
 * @property Menu $Menu
 */
class MenusController extends AppController
{
/**
 * Models to use
 *
 * @var array
 */
    public $uses = array('Menu', 'Page');

/**
 * beforeFilter method
 *
 * @return void
 */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('menu');
    }

/**
 * menu method
 *
 * Return an array of threaded menu item to be displayed (via a Helper).
 * Priority must be greater than zero to display the menu item.
 *
 * @return array
 */
    public function menu()
    {
        //  checks to make sure method is actually originating from requestAction()
        if (empty($this->request->params['requested'])) {
            throw new ForbiddenException();
        }

        // get menu items from cache, if expired get elements and cache
        $menuItems = Cache::read('menu', 'medium');
        if ($menuItems === false) {
            // if cache expired or non-existent, get latest
            $options = array(
                'conditions' => array('Menu.priority >' => 0),
                'recursive' => -1
            );
            $menuItems = $this->Menu->find('threaded', $options);
            Cache::write('menu', $menuItems, 'medium');
        }

        return $menuItems;
    }

/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index()
    {
        $this->layout = 'default_admin';
        $this->set('title_for_layout', 'Menu Items');

        $this->Paginator->settings = array('recursive' => 0);
        $this->set('menus', $this->Paginator->paginate());
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
        if (!$this->Menu->exists($id)) {
            throw new NotFoundException('Invalid Menu.');
        }
        $options = array('conditions' => array('Menu.id' => $id));
        $menu = $this->Menu->find('first', $options);
        $this->set(compact('menu'));
        $this->set('title_for_layout', 'Menu Item: '.$menu['Menu']['name']);
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
            $this->Menu->create();
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash('The Menu has been saved.', 'Flash/success');
                return $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->Session->setFlash('The Menu could not be saved. Please, try again.', 'Flash/error');
            }
        }
        $menuParents = $this->Menu->find('list', array('fields' => array('Menu.id', 'Menu.name'), 'order' => 'Menu.id'));
        $menuRoot = array(0 => 'Root');
        $parents = $menuRoot + $menuParents;
        $pages = $this->Page->find('all');
        $this->set('title_for_layout', 'Add Menu Item');
        $this->set(compact('parents', 'pages'));
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
        if (!$this->Menu->exists($id)) {
            throw new NotFoundException('Invalid Menu.');
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash('The menu has been saved.', 'Flash/success');
                return $this->redirect(array('action' => 'admin_index'));
            } else {
                $this->Session->setFlash('The Menu could not be saved. Please, try again.', 'Flash/error');
            }
        } else {
            $options = array('conditions' => array('Menu.id' => $id));
            $this->request->data = $this->Menu->find('first', $options);
        }
        $menuParents = $this->Menu->find('list', array('fields' => array('Menu.id', 'Menu.name'), 'order' => 'Menu.id'));
        $menuRoot = array(0 => 'Root');
        $parents = $menuRoot + $menuParents;
        $pages = $this->Page->find('all');
        $this->set('title_for_layout', 'Edit Menu Item');
        $this->set(compact('parents', 'pages'));
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

        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException('Invalid Menu.');
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Menu->delete()) {
            $this->Session->setFlash('Menu deleted.', 'Flash/success');
            return $this->redirect(array('action' => 'admin_index'));
        }
        $this->Session->setFlash('Menu was not deleted.', 'Flash/error');
        return $this->redirect(array('action' => 'admin_index'));
    }
}
