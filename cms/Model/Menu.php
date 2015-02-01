<?php
/**
 * Menu model.
 *
 * Manage Menu data. The model manages the menu items and use a
 * parent_id filed so that they can be organized in a hierarchy and
 * correctly displayed using threaded find operations. Link can be
 * internal (like /pages/index) or a full external URL (with http://).
 * Priority is used to order menu items in the same branch and a
 * priority of 0 hides the menu item.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Model.Menus
 */
App::uses('AppModel', 'Model');
/**
 * Menu Model
 *
 */
class Menu extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
/**
 * Default order
 *
 * @var array
 */
 	public $order = array(
 		'Menu.parent_id' => 'ASC',
 		'Menu.priority' => 'ASC',
 		'Menu.name' => 'ASC',
 	);
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => false,
				'last' => true, // Stop validation after this rule
			),
			'alphanumericextended' => array(
				'rule' => array('alphaNumericDashUnderscoreSpaceColon'),
				'message' => 'Names must only contain letters, numbers, spaces, dashes, underscores and colons.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'maxlength' => array(
				'rule' => array('maxLength', 128),
				'message' => 'Names must be no larger than 128 characters long.',
				'required' => false,
				'last' => true, // Stop validation after this rule
			),
		),
		'link' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => false,
				'last' => true, // Stop validation after this rule
			),
			'maxlength' => array(
				'rule' => array('maxLength', 255),
				'message' => 'Links must be no larger than 255 characters long.',
				'required' => false,
				'last' => true, // Stop validation after this rule
			),
		),
		'parent_id' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => false,
				'last' => true, // Stop validation after this rule
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'This field is numeric.',
				'required' => false,
				'last' => true, // Stop validation after this rule
			),
		),
		'priority' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => false,
				'last' => true, // Stop validation after this rule
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'This field is numeric.',
				'required' => false,
				'last' => true, // Stop validation after this rule
			),
		),
	);

/**
 * beforeValidate method
 *
 * @return boolean
 */
	public function beforeValidate($options = array()) {
		if (!empty($this->data)) {
			$this->data = $this->_cleanData($this->data);
		}
		return true;
	}

/**
 * afterSave method
 *
 * Delete the latest menu cache everytime a new menu element is saved.
 *
 * @param boolean $created
 * @return void
 */
	public function afterSave($created, $options = array()) {
		Cache::delete('menu');
	}

/**
 * _cleanData method
 *
 * Cleans data array from forms.
 *
 * @param array $data Array of data to clean.
 * @return array
 */
	private function _cleanData($data) {
		$data['Menu']['name'] = Menu::clean(Menu::purify($data['Menu']['name']));
		$data['Menu']['link'] = Menu::clean(Menu::purify(filter_var($data['Menu']['link'], FILTER_SANITIZE_URL)), array('encode' => false));
		$data['Menu']['parent_id'] = filter_var($data['Menu']['parent_id'], FILTER_SANITIZE_NUMBER_INT);
		$data['Menu']['priority'] = filter_var($data['Menu']['priority'], FILTER_SANITIZE_NUMBER_INT);
		return $data;
	}

}
