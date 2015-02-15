<?php
/**
 * Post model.
 *
 * Manage Post data.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Model.Posts
 */
App::uses('AppModel', 'Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

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
 * Preview images order
 *
 * @var array
 */
	public $orderPreviewImages = array('md', 'sm', 'xs', 'ml', 'lg');

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
	public function beforeValidate($options = array()) {
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
	public function afterSave($created, $options = array()) {
		// check to see if a year folder exists and if not, create one
		if ($created) {
			$options = array('conditions' => array('Post.id' => $this->id), 'recursive' => -1);
			$post = $this->find('first', $options);
			if ($post) {
				$folder = WWW_ROOT.'img'.DS.'posts'.DS.$post['Post']['year'].DS.sprintf("%010d", $this->id);
				$dir = new Folder();
				if (!is_file($folder)) {
					$dir->create($folder);
				}
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
	public function beforeDelete($cascade = true) {
		$options = array('conditions' => array('Post.id' => $this->id), 'recursive' => -1);
		$post = $this->find('first', $options);

		if ($post) {
			$dir = new Folder(WWW_ROOT.'img'.DS.'posts'.DS.$post['Post']['year'].DS.sprintf("%010d", $this->id));
			$dir->delete();
		}

		return true;
	}

/**
 * afterFind method
 *
 * Add preview_images to the results.
 *
 * @param array $results
 * @param boolean $primary
 * @return array
 */
	public function afterFind($results, $primary = false) {
		foreach ($results as $key => $val) {
			// check to see we have an id key, for example to exclude distinct years list
			if (isset($results[$key]['Post']['id']) && $primary) {
				$dir = new Folder(WWW_ROOT.'img'.DS.'posts'.DS.$results[$key]['Post']['year'].DS.sprintf("%010d", $results[$key]['Post']['id']));
				foreach ($this->orderPreviewImages as $value) {
					$images[$value] = $dir->find('.*\.'.$value.'\.jpg', true);
					$results[$key]['Post']['preview_images'] = $images;
				}
				$others = $dir->find('.*(?!\.xs|\.sm|\.md|\.ml|\.lg|\.vl|\.xl).{3}\.jpg', true);
				$results[$key]['Post']['preview_images']['others'] = $others;
			}
		}
		return $results;
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
		$data['Post']['title'] = Post::clean(Post::purify($data['Post']['title']));
		$data['Post']['summary'] = Post::clean(Post::purify($data['Post']['summary']));
		$data['Post']['content'] = Post::purify($data['Post']['content']);
		$data['Post']['slug'] = Post::clean(Post::purify($data['Post']['slug']), array('encode' => false));
		$data['Post']['user_id'] = filter_var($data['Post']['user_id'], FILTER_SANITIZE_NUMBER_INT);
		return $data;
	}

/**
 * deleteFile method
 *
 * Delete one file from the Post images folder. Returns true
 * if the images are deleted, false otherwise.
 *
 * @param string $filename
 * @return boolean
 */
	public function deleteFile($path = null) {
		if (empty($path)) return false;

		$file = new File($path);
		$result = $file->delete();

		return $result;
	}

}
