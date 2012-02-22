<?php
/**
 * Event model.
 *
 * Manage Event data.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       events
 * @subpackage    events.model
 */
App::uses('AppModel', 'Model');
App::uses('MySanitize', 'Utility');
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
	public function beforeValidate() {
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
	public function afterSave($created) {
		// check to see if a year folder exists and if not, create one
		if ($created) {
			$event = $this->read(null, $this->id);
			if (!is_file(IMAGES.'events'.DS.$event['Event']['year'])) {
				mkdir(IMAGES.'events'.DS.$event['Event']['year']);
			}
		}
	}

/**
 * beforeDelete method
 *
 * @param boolean $cascade
 * @return boolean
 */
	public function beforeDelete($cascade) {
		$event = $this->read(null, $this->id);
		$directory = IMAGES.'events'.DS.$event['Event']['year'];
		$filebasename = sprintf("%010d", $this->id);

		$images = glob($directory.DS.$filebasename.'.*');

		foreach ($images as $image) {
			unlink($image);
		}

		return true;
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
		$data['Event']['name'] = MySanitize::cleanSafe($data['Event']['name']);
		$data['Event']['date_start'] = Sanitize::paranoid(MySanitize::cleanSafe($data['Event']['date_start'], array('quotes' => ENT_NOQUOTES)), array('-', ':', ' '));
		$data['Event']['date_end'] = Sanitize::paranoid(MySanitize::cleanSafe($data['Event']['date_end'], array('quotes' => ENT_NOQUOTES)), array('-', ':', ' '));
		$data['Event']['location'] = MySanitize::cleanSafe($data['Event']['location']);
		$data['Event']['description'] = MySanitize::cleanSafe($data['Event']['location']);
		$data['Event']['webpage'] = MySanitize::cleanSafe($data['Event']['webpage'], array('quotes' => ENT_QUOTES));
		$data['Event']['slug'] = MySanitize::paranoid(MySanitize::cleanSafe($data['Event']['slug'], array('quotes' => ENT_NOQUOTES)), array(' ', '-', '_'));
		return $data;
	}

}
