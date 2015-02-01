/**
 * Javascript for the lightbox in the admin section.
 *
 * Javascript for the admin section, mainly to add a lightbox to
 * display images.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.webroot.javascript
 */
/**
 * Check the document is ready.
 */
$(document).ready(function() {
	/**
	 * Handler to enable the Magnific Popup lightbox.
	 */
	$('.popup-link').magnificPopup({
		type: 'image',
		titleSrc: 'title',
	});
});