<?php
/**
 * Albums admin view view.
 *
 * Displays thumbnails in a row of 6 2-columns and center the
 * images. Uses the Slimbox2 script to display the images in a lightbox:
 * http://www.digitalia.be/software/slimbox2
 * Slimbox2 must be loaded as a plugin in the bootstrap file.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Albums.View
 */
echo $this->Html->css('/slimbox2/css/slimbox2', array('inline' => false));
echo $this->Html->script(array('/slimbox2/js/slimbox2'), array('inline' => false));

$this->extend('/Common/view');

$this->assign('title', 'Album: '.$album['Album']['name']);
$this->assign('contentCreated', $album['Album']['created']);
?>
		<p><?php echo $album['Album']['description']; ?></p>
<?php
$this->start('extraContent');

	$i = 0;
	$last = count($albumImages['AlbumImage']) - 1;
	$images_path = 'albums/'.$album['Album']['year'].'/'.sprintf("%010d", $album['Album']['id']).'/';
	foreach ($albumImages['AlbumImage'] as $image):
?>
<?php
		if ($i%6 == 0):
?>
<div class="row"> <!-- start thumbnails row -->
<?php
		endif;
?>
	<div class="col-md-2">
		<?php echo $this->Html->link($this->Html->image($images_path.'thumbnails/'.$image, array('class' => null, 'alt' => $image, 'title' => $image)), '/img/'.$images_path.$image, array('class' =>'thumbnail', 'rel' => 'lightbox-project', 'escapeTitle' => false)) ;?>
	</div>
<?php
		if (($i%6 == 5) || ($i == $last)):
?>
</div> <!-- end thumbnails row -->
<div>&nbsp;</div>
<?php
		endif;
?>
<?php
	$i++;
	endforeach;
$this->end();
?>
