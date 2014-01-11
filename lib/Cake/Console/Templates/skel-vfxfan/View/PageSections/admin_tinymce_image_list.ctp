<?php
/**
 * Image List view for TinyMCE editor.
 *
 * Image List view for TinyMCE editor. Gets a list of images for a
 * page and builds a Javascript array for use in the TinyMCE editor
 * in the page sections.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.PageSections.View
 */
$images_list = array();
$page_folder = sprintf("%010d", $page_id);
foreach ($images as $image) {
	$images_list[] = "[\"$image\", \"img/pages/$page_folder/$image\"]";
}
?>
var tinyMCEImageList = new Array(
	// Name, URL
	<?php echo implode(",",$images_list); ?>
);
