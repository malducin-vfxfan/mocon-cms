<?php
/**
 * Resize Image component.
 *
 * ResizeImage component. It includes methods to coreectly resize an
 * image proportionally and based on image type.
 *
 * Based on the TutsPlus article:
 *
 * http://code.tutsplus.com/tutorials/image-resizing-made-easy-with-php--net-10362
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, ILMfan (http://ilmfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Controller.Component
 */
/**
 * Upload Component
 *
 * @property ResizeImageComponent $ResizeImageComponent
 * @property-read array
 */
class ResizeImageComponent extends Component {
	// Class variables
	private $image;
	private $width;
	private $height;
	private $imageResized;

/**
 * Constructor method
 *
 * @param $file string Complete file path
 * @param $fileType string MIME type of file
 * @return void
 */
	public function __construct($file, $fileType)
	{
		// Open up the file
		$this->image = $this->openImage($file, $fileType);

		// Get width and height
		list($this->width, $this->height) = getimagesize($file);
	}

/**
 * openImage method
 *
 * @param $file string Complete file path
 * @param $fileType string MIME type of file
 * @return mixed Image resource or boolean
 */
	private function openImage($file = null, $fileType = null)
	{
		if (empty($file)) {
			return false;
		}

		switch($fileType)
		{
			case 'image/jpg':
			case 'image/jpeg':
			case 'image/pjpeg':
				$img = imagecreatefromjpeg($file);
				break;
			case 'image/png':
			case 'image/x-png':
				$img = imagecreatefrompng($file);
				break;
			case 'image/gif':
				$img = imagecreatefromgif($file);
				break;
			default:
				$img = false;
				break;
		}
		return $img;
	}

/**
 * resizeImage method
 *
 * @param $newWidth int New desired width
 * @param $newHeight int New desired height
 * @param $resize string Type of resizing
 * @return void
 */
	public function resizeImage($newWidth, $newHeight, $resize = 'auto')
	{
		// Get optimal width and height - based on $resize
		$imageDimensions = $this->getDimensions($newWidth, $newHeight, strtolower($resize));

		$optimalWidth  = $imageDimensions['optimalWidth'];
		$optimalHeight = $imageDimensions['optimalHeight'];

		// Resample - create image canvas of x, y size
		$this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
		imagealphablending($this->imageResized, false);
		imagesavealpha($this->imageResized, true);
		imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);
	}

/**
 * getDimensions method
 *
 * @param $newWidth int New desired width
 * @param $newHeight int New desired height
 * @param $resize string Type of resizing
 * @return array
 */
	private function getDimensions($newWidth, $newHeight, $resize) {
		switch ($resize)
		{
			case 'exact':
				$optimalWidth = $newWidth;
				$optimalHeight= $newHeight;
				break;
			case 'portrait':
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight= $newHeight;
				break;
			case 'landscape':
				$optimalWidth = $newWidth;
				$optimalHeight= $this->getSizeByFixedWidth($newWidth);
				break;
			case 'auto':
				$imageDimensions = $this->getSizeByAuto($newWidth, $newHeight);
				$optimalWidth = $imageDimensions['optimalWidth'];
				$optimalHeight = $imageDimensions['optimalHeight'];
				break;
		}
		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}

/**
 * getSizeByFixedHeight method
 *
 * @param $newHeight int
 * @return int
 */
	private function getSizeByFixedHeight($newHeight)
	{
		$ratio = $this->width / $this->height;
		$newWidth = $newHeight * $ratio;
		return $newWidth;
	}

/**
 * method
 *
 * @param $newWidth int
 * @return int
 */
	private function getSizeByFixedWidth($newWidth)
	{
		$ratio = $this->height / $this->width;
		$newHeight = $newWidth * $ratio;
		return $newHeight;
	}

/**
 * getSizeByAuto method
 *
 * @param $newWidth int
 * @param $newHeight int
 * @return array
 */
	private function getSizeByAuto($newWidth, $newHeight)
	{
		if ($this->height < $this->width)
		// Image to be resized is wider (landscape)
		{
			$optimalWidth = $newWidth;
			$optimalHeight= $this->getSizeByFixedWidth($newWidth);
		}
		elseif ($this->height > $this->width)
		// Image to be resized is taller (portrait)
		{
			$optimalWidth = $this->getSizeByFixedHeight($newHeight);
			$optimalHeight= $newHeight;
		}
		else
		// Image to be resizerd is a square
		{
			if ($newHeight < $newWidth) {
				$optimalWidth = $newWidth;
				$optimalHeight= $this->getSizeByFixedWidth($newWidth);
			} else if ($newHeight > $newWidth) {
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight= $newHeight;
			} else {
				// Sqaure being resized to a square
				$optimalWidth = $newWidth;
				$optimalHeight= $newHeight;
			}
		}

		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}

/**
 * saveImage method
 *
 * @param $savePath string
 * @param $fileType string
 * @return void
 */
	public function saveImage($savePath, $fileType, $imageQuality = 100)
	{
		switch($fileType)
		{
			case 'image/jpg':
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($this->imageResized, $savePath, $imageQuality);
				break;

			case 'image/png':
			case 'image/x-png':
				// Scale quality from 0-100 to 0-9
				$scaleQuality = round(($imageQuality/100) * 9);

				// Invert quality setting as 0 is best, not 9
				$invertScaleQuality = 9 - $scaleQuality;

				imagepng($this->imageResized, $savePath, $invertScaleQuality);

				break;

			case 'image/gif':
				imagegif($this->imageResized, $savePath);
				break;
		}

		imagedestroy($this->imageResized);
	}

/**
 * method
 *
 * @param $savePath string
 * @param $fileType string
 * @param $imageQuality int
 * @return void
 */
	public function responsiveImages($savePath, $fileType, $imageQuality, $sizes = array()) {
		if (empty($sizes)) {
			return false;
		}

		$path_parts = pathinfo($savePath);

		// loop through the array
		foreach ($sizes as $ext => $size) {
			if ($size < $this->width) {
				$this->resizeImage($size, 0, 'landscape');
				$this->saveImage($path_parts['dirname'].DS.$path_parts['filename'].'.'.$ext.'.'.$path_parts['extension'], $fileType, $imageQuality);
			}
		}
	}

}
