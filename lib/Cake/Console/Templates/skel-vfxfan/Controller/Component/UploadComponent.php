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
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       component
 * @subpackage    component.upload
 */
/**
 * Upload Component
 *
 * @property UploadComponent $UploadComponent
 * @property-read array
 * @property-read array
 */
class UploadComponent extends Component {

/**
 * Permitted image types.
 *
 * @var array
 */
	private $permitted_images = array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/gif');
/**
 * Permitted file types.
 *
 * @var array
 */
	private $permitted_files = array('application/pdf');

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
 * uploadImageThumb method
 *
 * Uploads an image to the given folder, Uses the original image
 * name if none is specified. It also check to see that the file
 * uploaded is of the correct type specified in the $permitted_images
 * array.
 *
 * Several options can be specified:
 *
 * - create_thumb if true, create a thumbnail of the image, to be saved
 *   in a thumbnails folde specified in the $folder parameter. Default
 *   is false.
 * - twidth is the thumbnail maximum width, default 100px.
 * - theight is the thumbnail maximum height, default 100px.
 * - base_dir base directory for the folder where to store  the images,
 *   defaults to the webroot. Could be set to something like TMP to
 *   store outside the webroot.
 *
 * @param $folder string
 * @param $data array
 * @param $imagename string
 * @param array $options Array of options to use.
 * @return boolean
 */
	public function uploadImageThumb($folder = null, $data = null, $image_name = null, $options = array()) {
		$result = false;
		$typeOK = false;

		$default = array(
			'create_thumb' => false,
			'twidth' => 100,
			'theight' => 100,
			'base_dir' => WWW_ROOT
		);

		$options = array_merge($default, $options);

		// if no image name given use uploaded file name
		if (!$image_name)
			$image_name = $data['name'];

		// check file was uploaded
		if ($data['error'] == UPLOAD_ERR_OK) {
			$typeOK = $this->_checkTypes($data['type']);

			if ($typeOK) {
				//if we need to create a thumbnail
				if ($options['create_thumb']) {
					// Set initial maximum height and width
					$width = $options['twidth'];
					$height = $options['theight'];

					// Get original dimensions
					list($width_orig, $height_orig) = getimagesize($data['tmp_name']);

					$ratio_orig = $width_orig / $height_orig;

					if ($options['twidth'] / $options['theight'] > $ratio_orig) {
						$width = $options['theight'] * $ratio_orig;
					}
					else {
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

                    // copy thumbnail
					switch ($data['type']) {
						case 'image/jpg':
						case 'image/jpeg':
						case 'image/pjpeg':
							imagejpeg($thumb, $options['base_dir'].$folder.DS.'thumbnails'.DS.$image_name, 100);
							break;
						case 'image/png':
						case 'image/x-png':
							imagepng($thumb, $options['base_dir'].$folder.DS.'thumbnails'.DS.$image_name, 0);
							break;
						case 'image/gif':
							imagegif($thumb, $options['base_dir'].$folder.DS.'thumbnails'.DS.$image_name);
							break;
					}

					// destroy thumbnail, no longer needed
					imagedestroy($thumb);
				}

				// move uploaded image
				if ($image_name) {
					$result = move_uploaded_file($data['tmp_name'], $options['base_dir'].$folder.DS.$image_name);
				}
			}
		}
		elseif ($data['error'] == UPLOAD_ERR_NO_FILE) {
			$result = true;
		}
		return $result;
	}

/**
 * uploadFile method
 *
 * Uploads an file to the given folder, Uses the original image
 * name if none is specified. It also check to see that the file
 * uploaded is of the correct type specified in the $permitted_files
 * array.
 *
 * One option can be specified:
 *
 * - base_dir base directory for the folder where to store the files,
 *   defaults to the webroot. Could be set to something like TMP to
 *   store outside the webroot.
 *
 * @param $foder string
 * @param $data array
 * @param $filename string
 * @return boolean
 */
	public function uploadFile($folder = null, $data = null, $file_name = null, $options = array()) {
		$result = false;
		$typeOK = false;

		$default = array(
			'base_dir' => WWW_ROOT
		);

		$options = array_merge($default, $options);

		// if no image name given use uploaded file name
		if (!$file_name)
			$file_name = $data['name'];

		// check file was uploaded
		if ($data['error'] == UPLOAD_ERR_OK) {
			$typeOK = $this->_checkTypes($data['type'], array('file_types' => 'files'));

			if ($typeOK) {
				switch ($formdata['error']) {
					case UPLOAD_ERR_OK:
						// file uploaded correctly
						if ($file_name) {
							$result = move_uploaded_file($data['tmp_name'], $options['base_dir'].$folder.DS.$file_name);
						}
						else {
							$result = move_uploaded_file($data['tmp_name'], $options['base_dir'].$folder.DS.$data['name']);
						}
						break;
					case UPLOAD_ERR_NO_FILE:
						// no file to upload
						$result = true;
						break;
				}
			}
		}

		return $result;
	}

/**
 * _checkTypes method
 *
 * Check to see if the uploaded file is of a permitted MIME type. It
 * includes the option to specify what type of file to check: images
 * or general files and defaults to images.
 *
 * @param $form_data_type array
 * @param $file_type array
 * @return boolean
 */
	private function _checkTypes($form_data_type = null, $options = array()) {
		$type_ok = false;

		$default = array(
			'file_types' => 'images',
		);

		$options = array_merge($default, $options);

		if (empty($form_data_type))
			return $type_ok;

		switch ($options['file_types']) {
			case 'files':
				foreach ($this->permitted_files as $type) {
					if ($type == $form_data_type) {
						$type_ok = true;
						break;
					}
				}
				break;
			case 'images':
			default:
				foreach ($this->permitted_images as $type) {
					if ($type == $form_data_type) {
						$type_ok = true;
						break;
					}
				}
		}
		return $type_ok;
	}
}
