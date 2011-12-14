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
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       page_sections
 * @subpackage    page_sections.model
 */
App::uses('AppModel', 'Model');
App::uses('MySanitize', 'Utility');
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
		$data['PageSection']['title'] = MySanitize::cleanSafe($data['PageSection']['title']);
		$data['PageSection']['page_id'] = MySanitize::paranoid(MySanitize::cleanSafe($data['PageSection']['page_id'], array('quotes' => ENT_NOQUOTES)));
		$data['PageSection']['section'] = MySanitize::paranoid(MySanitize::cleanSafe($data['PageSection']['section'], array('quotes' => ENT_NOQUOTES)));
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
 * @return array
 */
	public function listFiles($id = null) {
		if (!$id) return;

		$images = array();
		$directory = IMAGES.'pages'.DS.sprintf("%010d", $id);
		$files = new DirectoryIterator($directory);

		foreach ($files as $filename) {
			if ($filename->isFile()) {
				$images[] = $filename->getBasename();
			}
		}

		sort($images);
		return $images;
	}

}
