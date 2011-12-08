/**
 * Javascript to add Page Sections in add Page form.
 *
 * Javascript to add Page Sections in add Page form. Allows to input
 * several sections on initial Page creation.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    javascript
 */
$(document).ready(function() {
	$('#addPageSection').click(function() {
		var num = $('.page_section_title').length; // how many page sections based on title field

		// create the new elements via clone(), and manipulate it's ID using newNum value
		var newElemTitle = $('#PageSection0Title').clone().attr('id', 'PageSection' + num + 'Title').attr('name', 'data[PageSection][' + num + '][title]');;
		var newElemSection = $('#PageSection0Section').clone().attr('id', 'PageSection' + num + 'Section').attr('name', 'data[PageSection][' + num + '][section]');;
		var newElemContent = $('#PageSection0Content').clone().attr('id', 'PageSection' + num + 'Content').attr('name', 'data[PageSection][' + num + '][content]');;

		// insert the new elements after the last "duplicatable" input field
		$('fieldset#extraPageSections').append('<div class="input text">');
		$('fieldset#extraPageSections').append('<label for="PageSection' + num + 'Title">Section Title</label>');
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
		$('fieldset#extraPageSections').append('<div><hr /></div>');

		// can only add 4 more page sections
		if (num == 5)  $('#addPageSection').attr('disabled','disabled');

	})
});