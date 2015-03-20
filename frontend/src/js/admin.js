/**
 * Javascript for the admin section.
 *
 * Javascript for the admin section, mainly to add interactivity like
 * adding form elements to existing forms and autocomplete for inputs.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.webroot.javascript
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

	/**
	 * Handlers for files drag and drop area.
	 *
	 * Handlers for drag and dropping files to a div for AJAX upload.
	 * We prevent the default events and their propagattion and set
	 * their classes accordingly for visual feedback.
	 */
	$('#dropzone-files, #dropzone-images, #dropzone-preview-images, #dropzone-album, #dropzone-album-thumbnails').on(
		'dragover',
		function(e) {
			$(this).attr('class', 'dropzone drop');
			e.preventDefault();
			e.stopPropagation();
	});

	$('#dropzone-files, #dropzone-images, #dropzone-preview-images, #dropzone-album, #dropzone-album-thumbnails').on(
		'dragleave',
		function(e) {
			$(this).attr('class', 'dropzone');
			e.preventDefault();
			e.stopPropagation();
	});

	$('#dropzone-files, #dropzone-images, #dropzone-preview-images, #dropzone-album, #dropzone-album-thumbnails').on(
		'drop',
		function(e) {
			$(this).attr('class', 'dropzone');
			e.preventDefault();
			e.stopPropagation();

			if (e.originalEvent.dataTransfer) {
				if (e.originalEvent.dataTransfer.files.length) {
					// upload files
					uploadFiles(e.originalEvent.dataTransfer.files, $(this).data("base"), $(this).data("controller"), $(this).data("id"), $(this).data("upload-type"), $(this).data("options"));
				}
			}
	});

	/**
	 * AJAX upload function.
	 *
	 * uploadFiles function will upload a series of files when
	 * dragged and dropped into a dropzone, via an AJAX call. We
	 * need a list of file, the base URL, Controller, data record id
	 * and a uploadType (to know if were uploading images of documents).
	 */

	function uploadFiles(files, base, controller, id, uploadType, options) {
		var formData = new FormData();
		for (var i = 0; i < files.length; i++) {
			formData.append("file-" + i, files[i]);
		}
		formData.append("options", JSON.stringify(options));

		$.ajax({
			url: base + '/admin/' + controller + '/ajaxUploadFiles/' + id + '/' + uploadType,
			type: 'POST',
			data: formData,
			async: false,
			success: function (data) {
				location.reload(true);
			},
			cache: false,
			contentType: false,
			processData: false
		});
	}

});