<?php
/**
 * Page Section model.
 *
 * Manage Page Section data. A page section must belong to a page, and
 * contains the actual content. The section field indicates the order
 * to display the section, and a value of 0 indicates an not published
 * (not displayed) section.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Model.PageSections
 */
App::uses('AppModel', 'Model');
App::uses('Folder', 'Utility');

/**
 * PageSection Model
 *
 * @property Page $Page
 */
class PageSection extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
/**
 * Default order
 *
 * @var array
 */
	public $order = array('PageSection.page_id' => 'ASC', 'PageSection.section' => 'ASC', 'PageSection.title' => 'ASC');
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'maxlength' => array(
				'rule' => array('maxLength', 128),
				'message' => 'Titles must be no larger than 128 characters long.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
		),
		'content' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
		),
		'page_id' => array(
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
		'section' => array(
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
		'Page' => array(
			'className' => 'Page',
			'foreignKey' => 'page_id',
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
 * _cleanData method
 *
 * Cleans data array from forms.
 *
 * @param array $data Array of data to clean.
 * @return array
 */
	private function _cleanData($data) {
		$data['PageSection']['title'] = PageSection::clean(PageSection::purify($data['PageSection']['title']));
		$data['PageSection']['content'] = PageSection::purify($data['PageSection']['content']);
		$data['PageSection']['page_id'] = filter_var($data['PageSection']['page_id'], FILTER_SANITIZE_NUMBER_INT);
		$data['PageSection']['section'] = filter_var($data['PageSection']['section'], FILTER_SANITIZE_NUMBER_INT);
		return $data;
	}

/**
 * listFiles method
 *
 * Return a list of file names inside the page images folder.
 * Useful when editing content and the images have already been
 * uploaded.
 *
 * @param string $id
 * @param string $location
 * @return array
 */
	public function listFiles($id = null, $location = null) {
		if (!$id || !$location) return;

		$dir = new Folder($location.DS.'pages'.DS.sprintf("%010d", $id));
		$files = $dir->find('.*', true);

		return $files;
	}

}
