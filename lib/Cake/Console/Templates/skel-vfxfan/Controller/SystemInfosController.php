<?php
/**
 * SystemInfos controller.
 *
 * SystemInfos actions. Display basic info of the system, like the
 * CakePHP, PHP and MySQL versions and all present controllers.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.SystemInfos.Controller
 */
App::uses('AppController', 'Controller');
/**
 * SystemInfos Controller
 *
 * @property SystemInfo $SystemInfo
 */
class SystemInfosController extends AppController {
/**
 * Models to use
 *
 * @var array
 */
	public $uses = array();

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'default_admin';

		// get system variables
		$cakephpVersion = Configure::version();
		$phpVersion = phpversion();
		$controllersPresent = str_replace('Controller', '', App::objects('Controller'));

		$this->set('title_for_layout', 'System Info');
		$this->set(compact('cakephpVersion', 'phpVersion', 'controllersPresent'));
	}

}
