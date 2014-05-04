<?php
/**
 * Image Format helper.
 *
 * Image Format helper. Contains methods to display a random image from a
 * specific folder and an image from a specific folder from an id or
 * from a folder named on the id.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Helper
 */
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

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
	private $exts = array('jpg', 'png', 'svg', 'gif');

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

		$dir = new Folder(WWW_ROOT.'img'.DS.$location);
		$images = $dir->find('.*', true);

		$imglink = $this->Html->image($location.'/'.$images[array_rand($images)], array('alt' => $options['alt'], 'title' => $options['title']));
		return $imglink;
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
 * @param string $location_default Location of default image, usually an enclosing folder (for example for posts)
 * @return mixed
 */
	public function idImage($location = null, $id = null, $options = array(), $location_default = null) {
		$default = array(
			'alt' => 'Image',
			'class' => 'img-thumbnail',
		);

		$options = array_merge($default, $options);

		if (!(isset($options['title'])) or !$options['title']) $options['title'] = $options['alt'];

		if (!$location or !$id) return;

		$dir = new Folder(WWW_ROOT.'img'.DS.$location);
		$images = $dir->find(sprintf("%010d", $id).'.*', true);

		$image_name = '';
		$ext = '';
		foreach ($images as $image) {
			$image = new File($dir->pwd().DS.$image);
			$ext = $image->ext();

			if (in_array($ext, $this->exts)) {
				$image_name = $image->name;
				break;
			}
		}
		if ($image_name) {
			if ($ext == 'svg') {
				$svg_options = array('type' => 'image/svg+xml', 'data' => $location.'/'.$image_name);
				$options = array_merge($svg_options, $options);

				$img_link = $this->Html->tag('object', $options['title'].' (your browser does not support SVG)', $options);
			}
			else {
				$img_link = $this->Html->image($location.'/'.$image_name, $options);
			}
		} else {
			// if default image is in the same location
			if (!$location_default) {
				$img_link = $this->Html->image($location.'/'.'default.png', $options);
			} else {
				// use the specified location of the default image
				// usually for images that are in subfolders like posts and events where the
				// default is in the enclosing folder
				$img_link = $this->Html->image($location_default.'/'.'default.png', $options);
			}
		}

		return $img_link;
	}
}
