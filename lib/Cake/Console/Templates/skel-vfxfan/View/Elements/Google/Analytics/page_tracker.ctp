<?php
/**
 * Google Analytics page tracker element.
 *
 * Should be placed at the bottom of the head section of a layout.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Elements.Google.Analytics
 */
$ga_code = Configure::read('Google.Analytics.trackerCode');
$ga_site = Configure::read('Google.Analytics.trackerSite');

if ($ga_code):
?>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', '<?php echo $ga_code; ?>', '<?php echo $ga_site; ?>');
	ga('send', 'pageview');
</script>
<?php endif; ?>