<?php
/**
 * Post model.
 *
 * Post model.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    posts
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
 * beforeValidate method
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
 * @param boolean $created
 * @return void
 */
	public function afterSave($created) {
		Cache::delete('latest_posts');
	}

/**
 * beforeDelete method
 *
 * @param boolean $cascade
 * @return void
 */
	public function beforeDelete($cascade) {
		$directory = IMAGES.'posts';
		$filebasename = sprintf("%010d", $this->id);

		$images = glob($directory.DS.$filebasename.'.*');

		foreach ($images as $image) {
			unlink($image);
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
		$data['Post']['title'] = MySanitize::cleanSafe($data['Post']['title']);
		$data['Post']['summary'] = MySanitize::cleanSafe($data['Post']['summary']);
		$data['Post']['slug'] = MySanitize::paranoid(MySanitize::cleanSafe($data['Post']['slug'], array('quotes' => ENT_NOQUOTES)), array(' ', '-', '_'));
		$data['Post']['user_id'] = MySanitize::paranoid(MySanitize::cleanSafe($data['Post']['user_id'], array('quotes' => ENT_NOQUOTES)), array(' ', '-', '_'));
		return $data;
	}

/**
 * getLatest method
 *
 * Return the most recent posts and caches the content.
 *
 * @param int $num_posts Number of recent posts to display and cache.
 * @return array
 */
	public function getLatest($num_posts = 5) {
		$latest_posts = Cache::read('latest_posts');
		if (!$latest_posts) {
			$this->recursive = 0;
			$latest_posts = $this->find('all', array('limit' => $num_posts));
			Cache::write('latest_posts', $latest_posts);
		}
		return $latest_posts;
	}

}
