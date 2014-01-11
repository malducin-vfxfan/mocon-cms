<?php
/**
 * Page model.
 *
 * Manage Page data. Pages only contain basic info: the overall title,
 * the slug and whether the page is set to be the main page. Content
 * is stored in the page sections.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Pages.Model
 */
App::uses('AppModel', 'Model');
/**
 * Page Model
 *
 * @property PageSection $PageSection
 */
class Page extends AppModel {
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
 	public $order = array('Page.title' => 'ASC');
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
				//'allowEmpty' => false,
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'isunique' => array(
				'rule' => array('isUnique'),
				'message' => 'This title has already been taken.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
		),
		'slug' => array(
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
				'rule' => array('maxLength', 128),
				'message' => 'Slugs must be no larger than 128 characters long.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'isunique' => array(
				'rule' => array('isUnique'),
				'message' => 'This slug has already been taken.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
		),
		'published' => array(
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
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'This field is boolean.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
		),
		'main' => array(
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
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'This field is boolean.',
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
		'PageSection' => array(
			'className' => 'PageSection',
			'foreignKey' => 'page_id',
			'dependent' => true,
		)
	);

/**
 * beforeValidate method
 *
 * If id doesn't exist (when adding a new record), create a slug from
 * the lowercase inflection of the page title.
 *
 * @return boolean
 */
	public function beforeValidate($options = array()) {
		if (!empty($this->data)) {
			if (!$this->id) {
				$this->data['Page']['slug'] = strtolower(Inflector::slug($this->data['Page']['title'], '-'));
			}
			$this->data = $this->_cleanData($this->data);
		}
		return true;
	}

/**
 * afterSave method
 *
 * Create a folder to place the page images, based on the page id.
 *
 * @param boolean $created
 * @return void
 */
	public function afterSave($created, $options = array()) {
		if ($created) {
			mkdir(IMAGES.'pages'.DS.sprintf("%010d", $this->id));
			mkdir(FILES.'pages'.DS.sprintf("%010d", $this->id));
		}
	}

/**
 * beforeDelete method
 *
 * Delete all images in the page folder and then remove the folder.
 *
 * @param boolean $cascade
 * @return boolean
 */
	public function beforeDelete($cascade = true) {
		$directory = IMAGES.'pages'.DS.sprintf("%010d", $this->id);
		$files = new DirectoryIterator($directory);

		foreach ($files as $filename) {
			if ($filename->isFile()) {
				unlink(IMAGES.'pages'.DS.sprintf("%010d", $this->id).DS.$filename->getBasename());
			}
		}

		rmdir($directory);

		$directory = FILES.'pages'.DS.sprintf("%010d", $this->id);
		$files = new DirectoryIterator($directory);

		foreach ($files as $filename) {
			if ($filename->isFile()) {
				unlink(FILES.'pages'.DS.sprintf("%010d", $this->id).DS.$filename->getBasename());
			}
		}

		rmdir($directory);

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
		$data['Page']['title'] = Page::clean(Page::purify($data['Page']['title']));
		$data['Page']['slug'] = Page::clean(Page::purify($data['Page']['slug']), array('encode' => false));
		$data['Page']['published'] = filter_var($data['Page']['published'], FILTER_SANITIZE_NUMBER_INT);
		$data['Page']['main'] = filter_var($data['Page']['main'], FILTER_SANITIZE_NUMBER_INT);

		// purify page sections
		$page_sections_num = count($data['PageSection']);
		for ($i = 0; $i < $page_sections_num; $i++) {
			$data['PageSection'][$i]['content'] = Page::purify($data['PageSection'][$i]['content']);
		}

		return $data;
	}

/**
 * listFiles method
 *
 * List all file name in the page image folder given its id.
 *
 * @param string $id
 * @param string $location
 * @return array
 */
	public function listFiles($id = null, $location = IMAGES) {
		if (!$id || !$location) return;

		$files = array();
		$directory = $location.'pages'.DS.sprintf("%010d", $id);
		$filesList = new DirectoryIterator($directory);

		foreach ($filesList as $filename) {
			if ($filename->isFile()) {
				$files[] = $filename->getBasename();
			}
		}

		sort($files);
		return $files;
	}

/**
 * deleteFile method
 *
 * Delete one file from the page images folder given the page id and
 * the filename.
 *
 * @param string $id
 * @param string $filename
 * @param string $location
 * @return boolean
 */
	public function deleteFile($id = null, $filename = null, $location = IMAGES) {
		if (!$id || !$filename || !$location) return false;

		$options = array('conditions' => array('Page.id' => $id));
		$page = $this->find('first', $options);
		if ($album) {
			return unlink($location.'pages'.DS.sprintf("%010d", $page['Page']['id']).DS.$filename);
		} else {
			return false;
		}
	}

}
