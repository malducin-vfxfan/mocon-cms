<?php
/**
 * Contact Form Email model.
 *
 * Manage Contact Form Email data.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       contact_form_emails
 * @subpackage    contact_form_emails.model
 */
App::uses('AppModel', 'Model');
App::uses('MySanitize', 'Utility');
/**
 * ContactFormEmail Model
 *
 */
class ContactFormEmail extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'email';
/**
 * Default order
 *
 * @var array
 */
 	public $order = array('ContactFormEmail.email' => 'ASC');
/**
 * Custom find methods
 *
 * @var array
 */
 	public $findMethods = array('active' =>  true);
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'email' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
			'maxlength' => array(
				'rule' => array('maxLength', 64),
				'message' => 'Emails must be no larger than 64 characters long.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
			'email' => array(
				'rule' => array('email'),
				'message' => 'This is not a valid email.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
			'isunique' => array(
				'rule' => array('isUnique'),
				'message' => 'This email has already been taken.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
		),
		'name' => array(
			'maxlength' => array(
				'rule' => array('maxLength', 64),
				'message' => 'Names must be no larger than 128 characters long.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
		),
		'active' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'This field is numeric.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'This field is boolean.',
				'required' => true,
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
 * _findActive method
 *
 * Find all current active contact form recipients.
 *
 * @return array
 */
	protected function _findActive($state, $query, $results = array()) {
		// get only active recipients
		if ($state == 'before') {
			$query['conditions']['ContactFormEmail.active'] = true;
			return $query;
		}
		// return an array of only emails
		if ($state == 'after') {
			$activeEmails = array();
			foreach ($results as $result) {
				$activeEmails[] = $result['ContactFormEmail']['email'];
			}
			$results = $activeEmails;
		}
		return $results;
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
		$data['ContactFormEmail']['email'] = MySanitize::cleanSafe($data['ContactFormEmail']['email']);
		$data['ContactFormEmail']['name'] = MySanitize::cleanSafe($data['ContactFormEmail']['name']);
		$data['ContactFormEmail']['active'] = MySanitize::paranoid(MySanitize::cleanSafe($data['ContactFormEmail']['active'], array('quotes' => ENT_NOQUOTES)));
		return $data;
	}

}
