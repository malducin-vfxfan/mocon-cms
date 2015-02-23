<?php
/**
 * Change Themes controller.
 *
 * Change Themes actions. Allow the user to switch between themes.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.Controller.ChangeThemes
 */
App::uses('AppController', 'Controller');
/**
 * ChangeThemes Controller
 *
 */
class ChangeThemesController extends AppController {
/**
 * Models to use
 *
 * @var array
 */
    public $uses = array();

/**
 * beforeFilter method
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
        // always allow the change action
        $this->Auth->allow('change');
    }

/**
 * admin_change method
 *
 * @return void
 */
    public function admin_change() {
        if ($this->Session->read('Config.theme') == 'default') {
            $this->Session->write('Config.theme', 'mobile');
        } else {
            $this->Session->write('Config.theme', 'default');
        }
        return $this->redirect($this->request->referer());
    }

/**
 * change method
 *
 * @return void
 */
    public function change() {
        if ($this->Session->read('Config.theme') == 'default') {
            $this->Session->write('Config.theme', 'mobile');
        } else {
            $this->Session->write('Config.theme', 'default');
        }
        return $this->redirect($this->request->referer());
    }

}
