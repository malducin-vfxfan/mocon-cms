<?php
/**
 * Albums admin view view.
 *
 * Displays thumbnails in a row of 6 2-columns and center the
 * images.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Albums
 */
echo $this->Html->css('magnific-popup', array('inline' => false));
echo $this->Html->script(array('jquery.magnific-popup', 'project-lightbox'), array('inline' => false));

$this->extend('/Common/view');

$this->assign('title', 'Album: '.$album['Album']['name']);
$this->assign('contentCreated', $album['Album']['created']);
?>
		<p><?php echo $album['Album']['description']; ?></p>
<?php
$this->start('extraContent');
?>
<div id="gallery">
<?php
	$i = 0;
	$last = count($albumImages['AlbumImage']) - 1;
	$images_path = 'albums/'.$album['Album']['year'].'/'.sprintf("%010d", $album['Album']['id']).'/';
	foreach ($albumImages['AlbumImage'] as $image):
		if ($i%6 == 0):
?>
<div class="row"> <!-- start thumbnails row -->
<?php
		endif;
?>
	<div class="album-thumbail-md text-center">
		<?php echo $this->Html->link($this->Html->image($images_path.'thumbnails/'.$image, array('class' => 'img-thumbnail', 'alt' => $image, 'title' => $image)), '/img/'.$images_path.$image, array('escapeTitle' => false, 'title' => $image)) ;?>
	</div>
<?php
		if (($i%6 == 5) || ($i == $last)):
?>
</div> <!-- end thumbnails row -->
<div>&nbsp;</div>
<?php
		endif;
	$i++;
	endforeach;
?>
</div>
<?php
$this->end();
?>
