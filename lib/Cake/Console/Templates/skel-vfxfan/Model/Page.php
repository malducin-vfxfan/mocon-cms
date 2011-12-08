<?php
/**
 * Page model.
 *
 * Page model.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    pages
 */
App::uses('AppModel', 'Model');
App::uses('MySanitize', 'Utility');
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
			'order' => 'PageSection.section ASC, PageSection.title ASC',
		)
	);

/**
 * beforeValidate method
 *
 * @return boolean
 */
	public function beforeValidate() {
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
 * @param boolean $created
 * @return void
 */
	public function afterSave($created) {
		if ($created) {
			mkdir(IMAGES.'pages'.DS.sprintf("%010d", $this->id));
		}
	}

/**
 * beforeDelete method
 *
 * @param boolean $cascade
 * @return boolean
 */
	public function beforeDelete($cascade) {
		$directory = IMAGES.'pages'.DS.sprintf("%010d", $this->id);
		$files = new DirectoryIterator($directory);

		foreach ($files as $filename) {
			if ($filename->isFile()) {
				unlink(IMAGES.'pages'.DS.sprintf("%010d", $this->id).DS.$filename->getBasename());
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
		$data['Page']['title'] = MySanitize::cleanSafe($data['Page']['title']);
		$data['Page']['slug'] = MySanitize::paranoid(MySanitize::cleanSafe($data['Page']['slug'], array('quotes' => ENT_NOQUOTES)), array('-', '_'));
		$data['Page']['main'] = MySanitize::paranoid(MySanitize::cleanSafe($data['Page']['main'], array('quotes' => ENT_NOQUOTES)));
		return $data;
	}

/**
 * listFiles method
 *
 * @param string $id
 * @return void
 */
	public function listFiles($id = null) {
		if (!$id) return;

		$directory = IMAGES.'pages'.DS.sprintf("%010d", $id);
		$files = new DirectoryIterator($directory);
		$images = array();

		foreach ($files as $filename) {
			if ($filename->isFile()) {
				$images[] = $filename->getBasename();
			}
		}

		return $images;
	}

/**
 * deleteFile method
 *
 * @param string $id
 * @param string $filename
 * @return boolean
 */
	public function deleteFile($id = null, $filename = null) {
		if (!id or !$filename) return false;

		return unlink(IMAGES.'pages'.DS.sprintf("%010d", $this->id).DS.$filename);
	}

}
