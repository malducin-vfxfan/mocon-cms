<?php
/**
 * User model.
 *
 * Manage User data. Users belong to a group.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       users
 * @subpackage    users.model
 */
App::uses('AppModel', 'Model');
App::uses('MySanitize', 'Utility');
/**
 * User Model
 *
 * @property Group $Group
 * @property Post $Post
 */
class User extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'username';
/**
 * Default order
 *
 * @var array
 */
 	public $order = array('User.username' => 'ASC');
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'username' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' =>true,
				'last' => true // Stop validation after this rule
			),
			'alphanumeric' => array(
				'rule' => array('alphaNumeric'),
				'message' => 'Usernames must only contain letters and numbers.',
				'required' =>true,
				'last' => true // Stop validation after this rule
			),
			'minlength' => array(
				'rule' => array('minLength', 8),
				'message' => 'Usernames must be at least 8 characters long.',
				'required' =>true,
				'last' => true // Stop validation after this rule
			),
			'maxlength' => array(
				'rule' => array('maxLength', 32),
				'message' => 'Usernames must be no larger than 32 characters long.',
				'required' =>true,
				'last' => true // Stop validation after this rule
			),
			'isunique' => array(
				'rule' => array('isUnique'),
				'message' => 'This username has already been taken.',
				'required' =>true,
				'last' => true // Stop validation after this rule
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' =>true,
				'last' => true // Stop validation after this rule
			),
		),
		'group_id' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' =>true,
				'last' => true // Stop validation after this rule
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'This field is numeric.',
				'required' =>true,
				'last' => true // Stop validation after this rule
			),
		),
	);
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
		)
	);
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'user_id',
			'dependent' => false,
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
 * beforeSave method
 *
 * Hashes the password field before saving.
 *
 * @param array $options Array of options to use.
 * @return boolean
 */
	public function beforeSave($options = array()) {
		$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
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
        $data['User']['username'] = MySanitize::paranoid(MySanitize::cleanSafe($data['User']['username'], array('quotes' => ENT_NOQUOTES)), array('-', '_'));
        $data['User']['password'] = MySanitize::paranoid(MySanitize::cleanSafe($data['User']['password'], array('quotes' => ENT_NOQUOTES)), array('-', '_'));
        $data['User']['group_id'] = MySanitize::paranoid(MySanitize::cleanSafe($data['User']['group_id'], array('quotes' => ENT_NOQUOTES)));
		return $data;
	}

}
