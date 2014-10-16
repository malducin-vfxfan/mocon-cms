/**
 * Javascript for the admin section.
 *
 * Javascript for the admin section, mainly to add interactivity like
 * adding form elements to existing forms and autocomplete for inputs.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.webroot.javascript
 */
/**
 * Check the document is ready.
 */
$(document).ready(function() {

	/**
	 * Handler to add Page Sections in add Page view.
	 *
	 * Handler to add Page Sections in add Page form. Allows to input
	 * several sections on initial Page creation.
	 */
	$('#addPageSection').click(function() {
		var num = $('.page-section-title').length; // how many page sections based on title field

		// create the new elements via clone(), and manipulate it's ID using newNum value
		var newElemTitle = $('#PageSection0Title').clone().attr('id', 'PageSection' + num + 'Title').attr('name', 'data[PageSection][' + num + '][title]');
		var newElemSection = $('#PageSection0Section').clone().attr('id', 'PageSection' + num + 'Section').attr('name', 'data[PageSection][' + num + '][section]');
		var newElemContent = $('#PageSection0Content').clone().attr('id', 'PageSection' + num + 'Content').attr('name', 'data[PageSection][' + num + '][content]');

		// insert the new elements after the last "duplicatable" input field
		$('fieldset#extraPageSections').append('<div class="input text">');
		$('fieldset#extraPageSections').append('<label class="page-section-title" for="PageSection' + num + 'Title">Section Title</label>');
		$('fieldset#extraPageSections').append(newElemTitle);
		$('fieldset#extraPageSections').append('</div>');
		$('fieldset#extraPageSections').append('<div class="input number">');
		$('fieldset#extraPageSections').append('<label for="PageSection' + num + 'Section">Section</label>');
		$('fieldset#extraPageSections').append(newElemSection);
		$('fieldset#extraPageSections').append('</div>');
		$('fieldset#extraPageSections').append('<label for="PageSection' + num + 'Content">Content</label>');
		$('fieldset#extraPageSections').append('<div class="input textarea">');
		$('fieldset#extraPageSections').append(newElemContent);
		$('fieldset#extraPageSections').append('</div>');
		$('fieldset#extraPageSections').append('<hr>');

		// can only add 4 more page sections
		if (num == 5)  $('#addPageSection').attr('disabled','disabled');

	});

	/**
	 * Handler to add a Page slug in the Menu add view.
	 *
	 * Handler to add a Page slug in the Menu add view. Allows to input
	 * several sections on initial Page creation.
	 */
	$('.menu-page-slug').click(function() {
		// get id value of clicked button to obtain the page slug
		var slug = $(this).attr('id');

		$('#MenuLink').val('/pages/view/' + slug);
	});
});