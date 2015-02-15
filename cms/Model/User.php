<?php
/**
 * User model.
 *
 * Manage User data. Users belong to a group.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Model.Users
 */
App::uses('AppModel', 'Model');
App::uses('BlowfishAdvancedPasswordHasher', 'Controller/Component/Auth');
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
 * Act as a Requester for ACL. Requires an implementation of
 * parentNode().
 *
 * @var array
 */
	public $actsAs = array('Acl' => array('type' => 'requester'));
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
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'alphanumericextended' => array(
				'rule' => array('alphaNumericDashUnderscoreSpaceColon'),
				'message' => 'Usernames must only contain letters, numbers, spaces, dashes, underscores and colons.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'minlength' => array(
				'rule' => array('minLength', 8),
				'message' => 'Usernames must be at least 8 characters long.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'maxlength' => array(
				'rule' => array('maxLength', 64),
				'message' => 'Usernames must be no larger than 32 characters long.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'isunique' => array(
				'rule' => array('isUnique'),
				'message' => 'This username has already been taken.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'maxlength' => array(
				'rule' => array('maxLength', 60),
				'message' => 'Passwords must be no larger than 60 characters long.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
		),
		'group_id' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'This field is numeric.',
				'required' => true,
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
	public function beforeValidate($options = array()) {
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
		$blowfishHasher = new BlowfishAdvancedPasswordHasher();
		$this->data['User']['password'] = $blowfishHasher->hash($this->data['User']['password']);
		return true;
	}

/**
 * parentNode method
 *
 * Used by the AclBehavior to determine parent->child relationships.
 * A model’s parentNode() method must return null or return a parent
 * Model reference.
 *
 * @return array
 */
	public function parentNode($type) {
		if (!$this->id && empty($this->data)) {
			return null;
		}
		if (isset($this->data['User']['group_id'])) {
			$groupId = $this->data['User']['group_id'];
		} else {
			$groupId = $this->field('group_id');
		}
		if (!$groupId) {
			return null;
		} else {
			return array('Group' => array('id' => $groupId));
		}
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
		$data['User']['username'] = User::clean(User::purify($data['User']['username']), array('encode' => false));
		$data['User']['password'] = User::clean(User::purify($data['User']['password']), array('encode' => false));
		$data['User']['group_id'] = filter_var($data['User']['group_id'], FILTER_SANITIZE_NUMBER_INT);
		return $data;
	}

}
