<?php
/**
 * Upload component.
 *
 * Upload component. It includes two  methods to upload images and files.
 * It also includes a method to check that the uploaded file is of a
 * permitted type. The image upload method includes the option to create
 * a thumbnail on upload.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Controller.Component
 */
/**
 * Upload Component
 *
 * @property UploadComponent $UploadComponent
 * @property-read array
 */
class UploadComponent extends Component {
/**
 * uploadFile method
 *
 * Uploads a file to the given folder, uses the original file
 * name if none is specified. It also check to see that the file
 * uploaded is of the correct type specified in the $options array.
 *
 * Options:
 *
 * - base_dir base directory for the folder where to store the files,
 *   defaults to the webroot. Could be set to something like TMP to
 *   store outside the webroot.
 * - files_types array of permitted MIME types.
 * - create_thumb a boolean to specify if we want to create a
 *   thumbnail image.
 * - twidth is the thumbnail width in pixels.
 * - theight is the thumbnail height in pixels.
 *
 * @param $folder string
 * @param $data array
 * @param $file_name string
 * @param $options array
 * @return boolean
 */
	public function uploadFile($folder = null, $data = null, $file_name = null, $options = array()) {
		$result = false;
		$typeOK = false;

		$default = array(
			'base_dir' => WWW_ROOT,
			'file_types' => array(),
			'create_thumb' => false,
			'twidth' => 200,
			'theight' => 200,
			'thumbs_folder' => true,
			'only_thumbnail' => false,
		);

		$options = array_merge($default, $options);

		// if no file name is given use uploaded file name
		if (empty($file_name)) {
			$file_name = $data['name'];
		}

		// check file was uploaded
		if ($data['error'] === UPLOAD_ERR_OK) {
			$typeOk = $this->checkTypes($data['type'], $options['file_types']);

			// file type allowed
			if ($typeOk) {
				if ($options['create_thumb']) {
					$this->createThumbnail($folder, $data, $file_name, $options);
				}

				if (empty($options['only_thumbnail'])) {
					$result = move_uploaded_file($data['tmp_name'], $options['base_dir'].$folder.DS.$file_name);
				}
			} elseif ($data['error'] === UPLOAD_ERR_NO_FILE) {
				// no file to upload
				$result = true;
			}
		}

		return $result;
	}

/**
 * uploadFiles method
 *
 * Uploads several files to the given folder. This method just loops
 * over the files array and calls the uploadFile method, passing the
 * exact same parameters.
 *
 * @param $folder string
 * @param $data array
 * @param $file_name string
 * @param $options array
 * @return boolean
 */

	public function uploadFiles($folder = null, $data = null, $file_name = null, $options = array()) {
		foreach ($data as $file) {
			$this->uploadFile($folder, $file, $file_name, $options);
		}
	}

/**
 * convertFilenameToId method
 *
 * Convert a filename to a zero padded 10 character length name
 * based on an id. It appends the filename extension.
 *
 * @param $id string
 * @param $filename string
 * @return string
 */
	public function convertFilenameToId($id = null, $filename = null) {
		return sprintf("%010d", $id).substr($filename, strrpos($filename, '.'));
	}

/**
 * checkTypes method
 *
 * Check to see if the uploaded file is of a permitted MIME type. It
 * includes the option to specify what type of file to check.
 * If no type is given, it defaults to images.
 *
 * @param $form_data_type array
 * @param $file_type array
 * @return boolean
 */
	private function checkTypes($form_data_type = null, $file_types = array()) {
		$type_ok = false;

		if (empty($file_types)) {
			$file_types = array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/svg+xml', 'image/gif');
		}

		if (empty($form_data_type)) {
			return $type_ok;
		}

		foreach ($file_types as $type) {
			if ($type === $form_data_type) {
				$type_ok = true;
				break;
			}
		}

		return $type_ok;
	}

/**
 * createThumbnail method
 *
 * Create a thumbail when we upload an image and place in the
 * thumbnails directory where the original image is stored.
 *
 * @param $foder string
 * @param $data array
 * @param $file_name string
 * @param $options array
 * @return boolean
 */
	private function createThumbnail($folder = null, $data = null, $file_name = null, $options = array()) {
		if (empty($folder) || empty($data)) {
			return false;
		}

		// Set initial maximum height and width
		$width = $options['twidth'];
		$height = $options['theight'];

		// Get original dimensions
		list($width_orig, $height_orig) = getimagesize($data['tmp_name']);

		$ratio_orig = $width_orig / $height_orig;

		if ($options['twidth'] / $options['theight'] > $ratio_orig) {
			$width = $options['theight'] * $ratio_orig;
		} else {
			$height = $options['twidth'] / $ratio_orig;
		}
		// thumbnail identifier
		$thumb = imagecreatetruecolor($width, $height);

		// Create image identifier of original upload
		switch ($data['type']) {
			case 'image/jpg':
			case 'image/jpeg':
			case 'image/pjpeg':
				$image_orig = imagecreatefromjpeg($data['tmp_name']);
				break;
			case 'image/png':
			case 'image/x-png':
				$image_orig = imagecreatefrompng($data['tmp_name']);
				break;
			case 'image/gif':
				$image_orig = imagecreatefromgif($data['tmp_name']);
				break;
		}

		// resample original to create thumbnail
		imagecopyresampled($thumb, $image_orig, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

		// check to see if we should use thumbnails folder
		if ($options['thumbs_folder']) {
			$location = $folder.DS.'thumbnails';
		} else {
			$location = $folder;
		}

		// copy thumbnail
		switch ($data['type']) {
			case 'image/jpg':
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($thumb, $options['base_dir'].$location.DS.$file_name, 100);
				break;
			case 'image/png':
			case 'image/x-png':
				imagepng($thumb, $options['base_dir'].$location.DS.$file_name, 0);
				break;
			case 'image/gif':
				imagegif($thumb, $options['base_dir'].$location.DS.$file_name);
				break;
		}

		// destroy thumbnail, no longer needed
		imagedestroy($thumb);

		return true;
	}
}
