/**
 * Javascript for the lightbox in the project (public sections).
 *
 * Javascript for the project, lightbox to display images.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.webroot.javascript
 */
/**
 * Check the document is ready.
 */
$(document).ready(function() {
	$('#gallery').magnificPopup({
		delegate: 'a',
		type: 'image',
		titleSrc: 'title',
		gallery: {enabled: true}
	});
});