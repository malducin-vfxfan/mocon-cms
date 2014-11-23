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
	$('#add-page-section').click(function() {
		var num = $('.page-section').length;
		var namePrefix = 'data[PageSection]';
		var idPrefix = 'PageSection';
		var idPageSection = 'page-section-';

		var newPageSection = $('#page-section-0').clone();

		$(newPageSection).attr('id', idPageSection + num);

		$(newPageSection).find('label[for=PageSection0Title]').attr('for', idPrefix + num + 'Title');
		$(newPageSection).find('#PageSection0Title').attr('name', namePrefix + '[' + num + ']' + '[title]').attr('id', idPrefix + num + 'Title');

		$(newPageSection).find('label[for=PageSection0Section]').attr('for', idPrefix + num + 'Section');
		$(newPageSection).find('#PageSection0Section').attr('name', namePrefix + '[' + num + ']' + '[section]').attr('id', idPrefix + num + 'Section');

		$(newPageSection).find('label[for=PageSection0Content]').attr('for', idPrefix + num + 'Content');
		$(newPageSection).find('#PageSection0Content').attr('name', namePrefix + '[' + num + ']' + '[content]').attr('id', idPrefix + num + 'Content');

		$('div#extra-page-sections').append(newPageSection);
		$('div#extra-page-sections').append('<hr>');

		// can only add 5 more page sections
		if (num === 5)  $('#add-page-section').attr('disabled','disabled');
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