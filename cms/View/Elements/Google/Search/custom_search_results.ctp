<?php
/**
 * Google search results.
 *
 * Simple Google search form results.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.Elements.Google.Search
 */
?>
<div id="cse" style="width: 100%;">Loading</div>
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript">
	google.load('search', '1', {language : 'en', style : google.loader.themes.V2_DEFAULT});
	google.setOnLoadCallback(function() {
	var customSearchOptions = {};
	var customSearchControl = new google.search.CustomSearchControl(
		'<?php echo  Configure::read('Google.Search.key'); ?>', customSearchOptions);
	customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
	var options = new google.search.DrawOptions();
	options.enableSearchResultsOnly();
	customSearchControl.draw('cse', options);
	function parseParamsFromUrl() {
		var params = {};
		var parts = window.location.search.substr(1).split('\x26');
		for (var i = 0; i < parts.length; i++) {
			var keyValuePair = parts[i].split('=');
			var key = decodeURIComponent(keyValuePair[0]);
			params[key] = keyValuePair[1] ?
				decodeURIComponent(keyValuePair[1].replace(/\+/g, ' ')) :
				keyValuePair[1];
		}
		return params;
	}

	var urlParams = parseParamsFromUrl();
	var queryParamName = "q";
	if (urlParams[queryParamName]) {
		customSearchControl.execute(urlParams[queryParamName]);
	}
}, true);
</script>
