<?php
/**
 * Group model.
 *
 * Manage Group data. Groups can have many users.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       groups
 * @subpackage    groups.model
 */
App::uses('AppModel', 'Model');
App::uses('MySanitize', 'Utility');
/**
 * Group Model
 *
 * @property User $User
 */
class Group extends AppModel {
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
 	public $order = array('Group.name' => 'ASC');
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
				'required' =>true,
				'last' => true // Stop validation after this rule
			),
			'alphanumeric' => array(
				'rule' => array('alphaNumeric'),
				'message' => 'Names must only contain letters and numbers.',
				'required' =>true,
				'last' => true // Stop validation after this rule
			),
			'maxlength' => array(
				'rule' => array('maxLength', 32),
				'message' => 'Names must be no larger than 32 characters long.',
				'required' =>true,
				'last' => true // Stop validation after this rule
			),
			'isunique' => array(
				'rule' => array('isUnique'),
				'message' => 'This name has already been taken.',
				'required' =>true,
				'last' => true // Stop validation after this rule
			),
		),
	);
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'group_id',
			'dependent' => true,
			'order' => 'User.username ASC',
		)
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
		$data['Group']['name'] = MySanitize::paranoid(MySanitize::cleanSafe($data['Group']['name'], array('quotes' => ENT_NOQUOTES)), array(' ', '-', '_'));
		return $data;
	}

}
