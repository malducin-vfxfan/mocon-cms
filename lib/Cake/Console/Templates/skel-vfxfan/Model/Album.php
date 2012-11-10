<?php
/**
 * Album model.
 *
 * Manage Album data. Albums have a thumbnail and their image folder
 * contains a thumbnails folder. It assumes the actual image and
 * thumbnail have the same name, the only thing that distinguishes
 * them is their location.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       albums
 * @subpackage    albums.model
 */
App::uses('AppModel', 'Model');
App::uses('MySanitize', 'Utility');
/**
 * Album Model
 *
 */
class Album extends AppModel {
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
 	public $order = array('Album.created' => 'DESC');
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
			'maxlength' => array(
				'rule' => array('maxLength', 128),
				'message' => 'Names must be no larger than 128 characters long.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
			'isunique' => array(
				'rule' => array('isUnique'),
				'message' => 'This name has already been taken.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
			'maxlength' => array(
				'rule' => array('maxLength', 255),
				'message' => 'Descriptions must be no larger than 255 characters long.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
		),
		'slug' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
			'maxlength' => array(
				'rule' => array('maxLength', 128),
				'message' => 'Slugs must be no larger than 128 characters long.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
			'isunique' => array(
				'rule' => array('isUnique'),
				'message' => 'This slug has already been taken.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
		),
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
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'AlbumImage' => array(
			'className' => 'AlbumImage',
		)
	);

/**
 * beforeValidate method
 *
 * If id doesn't exist (when adding a new record), create a slug from
 * the lowercase inflection of the album name.
 *
 * @return boolean
 */
	public function beforeValidate() {
		if (!empty($this->data)) {
			$this->data = $this->_cleanData($this->data);
			if (!$this->id) {
				$this->data['Album']['slug'] = strtolower(Inflector::slug($this->data['Album']['name'], '-'));
			}
		}
		return true;
	}

/**
 * afterSave method
 *
 * Create the album images folder and the thumbnails folder inside it.
 *
 * @param boolean $created
 * @return void
 */
	public function afterSave($created) {
		if ($created) {
			$album = $this->find('first', array('conditions' => array('Album.id' => $this->id)));
			if (!is_file(IMAGES.'albums'.DS.$album['Album']['year'])) {
				mkdir(IMAGES.'albums'.DS.$album['Album']['year']);
			}
			mkdir(IMAGES.'albums'.DS.$album['Album']['year'].DS.sprintf("%010d", $this->id));
			mkdir(IMAGES.'albums'.DS.$album['Album']['year'].DS.sprintf("%010d", $this->id).DS.'thumbnails');
		}
	}

/**
 * beforeDelete method
 *
 * Delete all images inside the thumbnails folder and the image album
 * folder and reove the folders. Then remove the folder thumbnail.
 * It returns true hen the operation completes, even if there's a
 * problem removing something.
 *
 * @param boolean $cascade
 * @return boolean
 */
	public function beforeDelete($cascade) {
		$album = $this->find('first', array('conditions' => array('Album.id' => $this->id)));
		$directory = IMAGES.'albums'.DS.$album['Album']['year'].DS.sprintf("%010d", $this->id);
		$files = new DirectoryIterator($directory.DS.'thumbnails');

		foreach ($files as $filename) {
			if ($filename->isFile()) {
				unlink($directory.DS.'thumbnails'.DS.$filename->getBasename());
			}
		}

		rmdir($directory.DS.'thumbnails');

		$files = new DirectoryIterator($directory);

		foreach ($files as $filename) {
			if ($filename->isFile()) {
				unlink($directory.DS.$filename->getBasename());
			}
		}

		rmdir($directory);

		$directory = IMAGES.'albums'.DS.$album['Album']['year'];
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
		$data['Album']['name'] = MySanitize::cleanSafe($data['Album']['name']);
		$data['Album']['slug'] = MySanitize::paranoid(MySanitize::cleanSafe($data['Album']['slug'], array('quotes' => ENT_NOQUOTES)), array('-', '_'));
		$data['Album']['description'] = MySanitize::cleanSafe($data['Album']['description']);
		return $data;
	}

/**
 * getAlbumThumbnails method
 *
 * Return a sorted list of all images in an album thumbnails folder.
 *
 * @param string $id
 * @return array
 */
	public function getAlbumThumbnails($id = null, $year = null) {
		if (!$id || !$year) return array();

		$images = array();
		$directory = IMAGES.'albums'.DS.$year.DS.sprintf("%010d", $id).DS.'thumbnails';
		$files = new DirectoryIterator($directory);

		foreach ($files as $filename) {
			if ($filename->isFile()) {
				$images[] = $filename->getBasename();
			}
		}

		sort($images);
		return $images;
	}

/**
 * deleteFile method
 *
 * delete and album file inside the album images folder. It deletes
 * both the image and its thummbnail. Returns true if both images are
 * deleted, false otherwise. This means it could potentially return
 * false if one image is deleted but not the other.
 *
 * @param string $id
 * @param string $filename
 * @return boolean
 */
	public function deleteFile($id = null, $filename = null) {
		if (!$id || !$filename) return false;

		$album = $this->find('first', array('conditions' => array('Album.id' => $id)));

		$del_thumb = unlink(IMAGES.'albums'.DS.$album['Album']['year'].DS.sprintf("%010d", $this->id).DS.'thumbnails'.DS.$filename);
		$del_image = unlink(IMAGES.'albums'.DS.$album['Album']['year'].DS.sprintf("%010d", $this->id).DS.$filename);

		return ($del_thumb && $del_image);
	}

}
