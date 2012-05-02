<?php
/**
 * Google Analytics page tracker element.
 *
 * Should be placed at the bottom of the head section of a layout.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       google
 * @subpackage    google.analytics.views.elements
 */
$ga_code = Configure::read('GoogleAnalytics.trackerCode');
if ($ga_code):
?>
<script type="text/javascript">
	var _gaq = _gaq || [];  _gaq.push(['_setAccount', '<?php echo $ga_code; ?>']);
	_gaq.push(['_trackPageview']);
	(function() {
		var ga = document.createElement('script');
		ga.type = 'text/javascript';
		ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(ga, s);
	})();
</script>
<?php endif; ?>