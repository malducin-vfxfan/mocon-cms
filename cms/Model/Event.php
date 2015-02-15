<?php
/**
 * Event model.
 *
 * Manage Event data.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Model.Events
 */
App::uses('AppModel', 'Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Event Model
 *
 */
class Event extends AppModel {
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
	public $order = array(
		'Event.date_start' => 'ASC',
		'Event.name' => 'ASC'
	);
/**
 * Custom find methods
 *
 * @var array
 */
	public $findMethods = array('upcoming' =>  true);
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
		'date_start' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
			'date' => array(
				'rule' => array('date'),
				'message' => 'Enter a valid date in YYYY-MM-DD format.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
		),
		'date_end' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
			'date' => array(
				'rule' => array('date'),
				'message' => 'Enter a valid date in YYYY-MM-DD format.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
		),
		'location' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be left blank.',
				'required' => true,
				'last' => true, // Stop validation after this rule
			),
			'maxlength' => array(
				'rule' => array('maxLength', 128),
				'message' => 'Locations must be no larger than 128 characters long.',
				'required' => true,
				'last' => true, // Stop validation after this rule
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
		'webpage' => array(
			'maxlength' => array(
				'rule' => array('maxLength', 64),
				'message' => 'Webpages must be no larger than 64 characters long.',
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
			'alphanumericextended' => array(
				'rule' => array('alphaNumericDashUnderscoreSpaceColon'),
				'message' => 'Names must only contain letters, numbers, spaces, dashes, underscores and colons.',
				'required' => true,
				'last' => true // Stop validation after this rule
			),
			'maxlength' => array(
				'rule' => array('maxLength', 140),
				'message' => 'Names must be no larger than 140 characters long.',
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
 * @return boolean
 */
	public function beforeValidate($options = array()) {
		if (!empty($this->data)) {
			if (!$this->id) {
				$this->data['Event']['slug'] = strtolower(Inflector::slug($this->data['Event']['name'].'-'.$this->data['Event']['date_start'], '-'));
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
			$options = array('conditions' => array('Event.id' => $this->id));
			$event = $this->find('first', $options);
			if ($event) {
				$folder = WWW_ROOT.'img'.DS.'events'.DS.$event['Event']['year'].DS.sprintf("%010d", $this->id);
				$dir = new Folder();
				if (!is_file($folder)) {
					$dir->create($folder);
				}
			}
		}
	}

/**
 * beforeDelete method
 *
 * @param boolean $cascade
 * @return boolean
 */
	public function beforeDelete($cascade = true) {
		$options = array('conditions' => array('Event.id' => $this->id));
		$event = $this->find('first', $options);

		if ($event) {
			$dir = new Folder(WWW_ROOT.'img'.DS.'events'.DS.$event['Event']['year'].DS.sprintf("%010d", $this->id));
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
			if (isset($results[$key]['Event']['id']) && $primary) {
				$dir = new Folder(WWW_ROOT.'img'.DS.'events'.DS.$results[$key]['Event']['year'].DS.sprintf("%010d", $results[$key]['Event']['id']));
				foreach ($this->orderPreviewImages as $value) {
					$images[$value] = $dir->find('.*\.'.$value.'\.jpg', true);
					$results[$key]['Event']['preview_images'] = $images;
				}
				$others = $dir->find('.*(?!\.xs|\.sm|\.md|\.ml|\.lg|\.vl|\.xl).{3}\.jpg', true);
				$results[$key]['Event']['preview_images']['others'] = $others;
			}
		}
		return $results;
	}

/**
 * _findUpcoming method
 *
 * Find the upcoming events.
 *
 * @return array
 */
	protected function _findUpcoming($state, $query, $results = array()) {
		if ($state == 'before') {
			$this->recursive = 0;
			$query['conditions']['Event.date_end >='] = date('Y-m-d');
			$query['limit'] = Configure::read('Events.upcoming_num');
			return $query;
		}
		if ($state == 'after') {
			// if we get results, cache them
			Cache::write('upcoming_events', $results);
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
		$data['Event']['name'] = Event::clean(Event::purify($data['Event']['name']));
		$data['Event']['date_start'] = Event::clean(Event::purify($data['Event']['date_start']), array('encode' => false));
		$data['Event']['date_end'] = Event::clean(Event::purify($data['Event']['date_end']), array('encode' => false));
		$data['Event']['location'] = Event::clean(Event::purify($data['Event']['location']));
		$data['Event']['description'] = Event::clean(Event::purify($data['Event']['description']));
		$data['Event']['webpage'] = Event::clean(Event::purify(filter_var($data['Event']['webpage'], FILTER_SANITIZE_URL)), array('encode' => false));
		$data['Event']['slug'] = Event::clean(Event::purify($data['Event']['slug']), array('encode' => false));
		return $data;
	}

/**
 * deleteFile method
 *
 * Delete one file from the Event images folder. Returns true
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
