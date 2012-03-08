<?php
/**
 * Post model.
 *
 * Manage Post data.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       posts
 * @subpackage    posts.model
 */
App::uses('AppModel', 'Model');
App::uses('MySanitize', 'Utility');
/**
 * Post Model
 *
 * @property User $User
 */
class Post extends AppModel {
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
 	public $order = array('Post.created' => 'DESC');
/**
 * Custom find methods
 *
 * @var array
 */
 	public $findMethods = array('latest' =>  true);
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
			'isunique' => array(
				'rule' => array('isUnique'),
				'message' => 'This title has already been taken.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
		),
		'summary' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'maxlength' => array(
				'rule' => array('maxLength', 255),
				'message' => 'Summaries must be no larger than 255 characters long.',
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
		'user_id' => array(
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		)
	);

/**
 * constructor method
 *
 * Create virtual fields.
 *
 * @param mixed $id The id to start the model on
 * @param string $table The table to use for this model
 * @param string $ds The connection name this model is connected to
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->virtualFields['year'] = sprintf('YEAR(%s.created)', $this->alias);
	}

/**
 * beforeValidate method
 *
 * If id doesn't exist (when adding a new record), create a slug from
 * the lowercase inflection of the post title.
 *
 * @return boolean
 */
	public function beforeValidate() {
		if (!empty($this->data)) {
			if (!$this->id) {
				$this->data['Post']['slug'] = strtolower(Inflector::slug($this->data['Post']['title'], '-'));
			}
			$this->data = $this->_cleanData($this->data);
		}
		return true;
	}

/**
 * afterSave method
 *
 * Delete the latest posts cache everytime a new post is added.
 *
 * @param boolean $created
 * @return void
 */
	public function afterSave($created) {
		// check to see if a year folder exists and if not, create one
		if ($created) {
			$post = $this->find('first', array('conditions' => array('id' => $this->id)));
			if (!is_file(IMAGES.'posts'.DS.$post['Post']['year'])) {
				mkdir(IMAGES.'posts'.DS.$post['Post']['year']);
			}
		}
		Cache::delete('latest_posts');
	}

/**
 * beforeDelete method
 *
 * Delete any images related to the post.
 *
 * @param boolean $cascade
 * @return boolean
 */
	public function beforeDelete($cascade) {
		$post = $this->find('first', array('conditions' => array('id' => $this->id)));
		$directory = IMAGES.'posts'.DS.$post['Post']['year'];
		$filebasename = sprintf("%010d", $this->id);

		$images = glob($directory.DS.$filebasename.'.*');

		foreach ($images as $image) {
			unlink($image);
		}

		return true;
	}

/**
 * _findLatest method
 *
 * Find the latest posts.
 *
 * @return array
 */
	protected function _findLatest($state, $query, $results = array()) {

		if ($state == 'before') {
			$this->recursive = 0;
			$query['limit'] = Configure::read('Posts.latest_num');
			return $query;
		}
		if ($state == 'after') {
			// if we get results, cache them
			Cache::write('latest_posts', $results);
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
		$data['Post']['title'] = MySanitize::cleanSafe($data['Post']['title']);
		$data['Post']['summary'] = MySanitize::cleanSafe($data['Post']['summary']);
		$data['Post']['slug'] = MySanitize::paranoid(MySanitize::cleanSafe($data['Post']['slug'], array('quotes' => ENT_NOQUOTES)), array('-', '_'));
		$data['Post']['user_id'] = MySanitize::paranoid(MySanitize::cleanSafe($data['Post']['user_id'], array('quotes' => ENT_NOQUOTES)));
		return $data;
	}
}
