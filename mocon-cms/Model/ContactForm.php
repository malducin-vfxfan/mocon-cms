<?php
/**
 * ContactForm model.
 *
 * Manage Contact Form data.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.Model.ContactForms
 */
App::uses('AppModel', 'Model');
/**
 * ContactForm Model
 *
 */
class ContactForm extends AppModel
{
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
    public $order = array('ContactForm.created' => 'DESC');
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
                'last' => true, // Stop validation after this rule
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
                'last' => true, // Stop validation after this rule
            ),
        ),
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
        ),
        'message' => array(
            'notempty' => array(
                'rule' => array('notEmpty'),
                'message' => 'This field cannot be left blank.',
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
    public function beforeValidate($options = array())
    {
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
    private function _cleanData($data)
    {
        $data['ContactForm']['name'] = ContactForm::clean(ContactForm::purify($data['ContactForm']['name']));
        $data['ContactForm']['email'] = ContactForm::clean(ContactForm::purify(filter_var($data['ContactForm']['email'], FILTER_SANITIZE_EMAIL)));
        $data['ContactForm']['message'] = nl2br(ContactForm::clean(ContactForm::purify($data['ContactForm']['message']), array('clean_whitespace' => false)));
        return $data;
    }

}
