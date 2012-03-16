/**
 * Javascript for the project (public sections).
 *
 * Javascript for the project, mainly to add interactivity like
 * the topbar menu.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       javascript
 * @subpackage    javascript.project
 */
/**
 * Check the document is ready.
 */
 $(document).ready(function() {

	/**
	 * Display the dropdown menu in the top bar.
	 */
	$(function() {
		$('#topbar').dropdown();
	});

});