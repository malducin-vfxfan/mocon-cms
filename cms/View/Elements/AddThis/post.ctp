<?php
/**
 * AddThis posts element.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Elements.AddThis
 */
$addthis_pubid = Configure::read('AddThis.pubid');
if ($addthis_pubid):
?>
<script>
	var addthis_config = {
		data_track_clickback: false
	};
</script>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style <?php if (Configure::read('AddThis.style_32')) echo 'addthis_32x32_style';?>"
	addthis:title="<?php echo Configure::read('AddThis.title').' '.$post_title; ?>"
	addthis:url="<?php echo $this->Html->url(array('controller' => 'posts', 'action' => 'view', $slug), true); ?>"
>
	<a class="addthis_button_facebook"></a>
	<a class="addthis_button_twitter"></a>
	<a class="addthis_button_favorites"></a>
	<a class="addthis_button_email"></a>
	<a class="addthis_button_print"></a>
	<a class="addthis_button_compact"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=<?php echo $addthis_pubid; ?>"></script>
<!-- AddThis Button END -->
<?php endif; ?>
