<?php
/**
 * Image Format helper.
 *
 * Image Format helper. Contains methods to display a random image from a
 * specific folder and an image from a specific folder from an id or
 * from a folder named on the id.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       views
 * @subpackage    views.helpers
 */
/**
 * FormatImage Helper
 *
 * @property FormatImageHelper $FormatImageHelper
 * @property array $helpers
 * @property-read array $exts
 */
class FormatImageHelper extends AppHelper {

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Html');
/**
 * Permitted image file extensions.
 *
 * @var array
 */
	private $exts = array('jpg', 'png', 'gif');


/**
 * randomImage method
 *
 * Return a random image from a given location
 *
 * @param $location string
 * @param $options array
 * @return mixed
 */
	public function randomImage($location = null, $options = array()) {
		$images = array();

		$default = array(
			'alt' => 'Image',
		);

		$options = array_merge($default, $options);

		if (!(isset($options['title'])) or !$options['title']) $options['title'] = $options['alt'];

		if (!$location) return;

		$directory = IMAGES.$location;
		$files = new DirectoryIterator($directory);

		foreach ($files as $filename) {
			if ($filename->isFile()) {
				$images[] = $filename->getFilename();
			}
		}

		$imglink = $this->Html->image($location.'/'.$images[array_rand($images)], array('alt' => $options['alt'], 'title' => $options['title']));
		return $this->output($imglink);
	}

/**
 * idImage method
 *
 * Return an image from a given location from the id field. If not found
 * return a default (PNG) image.
 *
 * @param string $location
 * @param string $id
 * @param arrayn $options
 * @param string $default_location Location of default image, usually an enclosing folder (for example for posts)
 * @return mixed
 */
	public function idImage($location = null, $id = null, $options = array(), $location_default = null) {
		$default = array(
			'alt' => 'Image',
			'class' => 'framed',
		);

		$options = array_merge($default, $options);

		if (!(isset($options['title'])) or !$options['title']) $options['title'] = $options['alt'];

		if (!$location or !$id) return;

		$directory = IMAGES.$location;
		$file_basename = sprintf("%010d", $id);
		$images = glob($directory.DS.$file_basename.'.*');

		$image_name = '';
		foreach ($images as $image) {
			$info = pathinfo($image);
			if (in_array($info['extension'], $this->exts)) {
				$image_name = $info['basename'];
				break;
			}
		}
		if ($image_name) {
			$img_link = $this->Html->image($location.'/'.$image_name, $options);
		}
		else {
			// if default image is in the same location
			if (!$location_default) {
				$img_link = $this->Html->image($location.'/'.'default.png', $options);
			}
			// use the specified location of the default image
			// usually for images that are in subfolders like posts and events where the
			// default is in the enclosing folder
			else {
				$img_link = $this->Html->image($location_default.'/'.'default.png', $options);
			}
		}

		return $this->output($img_link);
	}
}
