<?php
/**
 * Group model.
 *
 * Manage Group data. Groups can have many users.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Model.Groups
 */
App::uses('AppModel', 'Model');
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
		'name' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'alphanumericextended' => array(
				'rule' => array('alphaNumericDashUnderscoreSpaceColon'),
				'message' => 'Names must only contain letters, numbers, spaces, dashes, underscores and colons.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'maxlength' => array(
				'rule' => array('maxLength', 64),
				'message' => 'Names must be no larger than 64 characters long.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'isunique' => array(
				'rule' => array('isUnique'),
				'message' => 'This name has already been taken.',
				'required' => true,
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
 * parentNode method
 *
 * Used by the AclBehavior to determine parent->child relationships.
 * A model’s parentNode() method must return null or return a parent
 * Model reference.
 *
 * @return array
 */
	public function parentNode($type) {
		// since groups dont have parents
		return null;
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
		$data['Group']['name'] = Group::clean(Group::purify($data['Group']['name']), array('encode' => false));
		return $data;
	}

}
