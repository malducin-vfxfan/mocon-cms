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
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       menus
 * @subpackage    menus.model
 */
App::uses('AppModel', 'Model');
App::uses('MySanitize', 'Utility');
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
			'maxlength' => array(
				'rule' => array('maxLength', 64),
				'message' => 'Names must be no larger than 64 characters long.',
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
				'rule' => array('maxLength', 64),
				'message' => 'Links must be no larger than 32 characters long.',
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
	public function beforeValidate() {
		if (!empty($this->data)) {
			$this->data = $this->_cleanData($this->data);
		}
		return true;
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
		$data['Menu']['name'] = MySanitize::cleanSafe($data['Menu']['name']);
		$data['Menu']['link'] = MySanitize::cleanSafe($data['Menu']['link']);
		$data['Menu']['parent_id'] = MySanitize::paranoid(MySanitize::cleanSafe($data['Menu']['parent_id'], array('quotes' => ENT_NOQUOTES)));
		$data['Menu']['priority'] = MySanitize::paranoid(MySanitize::cleanSafe($data['Menu']['priority'], array('quotes' => ENT_NOQUOTES)));
		return $data;
	}

}
