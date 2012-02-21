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
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       menus
 * @subpackage    menus.controller
 */
App::uses('AppController', 'Controller');
/**
 * Menus Controller
 *
 * @property Menu $Menu
 */
class MenusController extends AppController {
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
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('menu');
	}

/**
 * menu method
 *
 * Return an array of threaded menu item to be displayed (via an element).
 * Priority must be greater than zero to display the menu item.
 *
 * @return array
 */
 	public function menu() {
		$this->Menu->recursive = -1;

		// get menu items from cache, if expired get elements and cache
		$menuItems = Cache::read('menu');
		if ($menuItems === false) {
			// if cache expired or non-existent, get latest
			$menuItems = $this->Menu->find('threaded', array('conditions' => array('priority >' => 0)));
			Cache::write('menu', $menuItems);
		}

		return $menuItems;
 	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';
		$this->Menu->recursive = 0;
		$this->set('title_for_layout', 'Menu Items');
		$this->set('menus', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'default_admin';
		$this->Menu->id = $id;
		if (!$this->Menu->exists()) {
			throw new NotFoundException('Invalid Menu.');
		}
		$menu = $this->Menu->read(null, $id);
		$this->set(compact('menu'));
		$this->set('title_for_layout', 'Menu Item: '.$menu['Menu']['name']);
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'default_admin';
		if ($this->request->is('post')) {
			$this->Menu->create();
			if ($this->Menu->save($this->request->data)) {
				$this->Session->setFlash('The Menu has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Menu could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
			}
		}
		$menuParents = $this->Menu->find('list', array('fields' => array('Menu.id', 'Menu.name'), 'order' => 'Menu.id'));
		$menuRoot = array(0 => 'Root');
		$parents = array_merge($menuRoot, $menuParents);
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
	public function admin_edit($id = null) {
		$this->layout = 'default_admin';
		$this->Menu->id = $id;
		if (!$this->Menu->exists()) {
			throw new NotFoundException('Invalid Menu.');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Menu->save($this->request->data)) {
				$this->Session->setFlash('The menu has been saved.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash('The Menu could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error'));
			}
		} else {
			$this->request->data = $this->Menu->read(null, $id);
		}
		$menuParents = $this->Menu->find('list', array('fields' => array('Menu.id', 'Menu.name'), 'order' => 'Menu.id'));
		$menuRoot = array(0 => 'Root');
		$parents = array_merge($menuRoot, $menuParents);
		$pages = $this->Page->find('all');
		$this->set('title_for_layout', 'Edit Menu Item');
		$this->set(compact('parents', 'pages'));
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
		$this->Menu->id = $id;
		if (!$this->Menu->exists()) {
			throw new NotFoundException('Invalid Menu.');
		}
		if ($this->Menu->delete()) {
			$this->Session->setFlash('Menu deleted.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash('Menu was not deleted.', 'default', array('class' => 'alert alert-error'));
		$this->redirect(array('action' => 'admin_index'));
	}
}
