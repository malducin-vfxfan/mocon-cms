<?php
/**
 * Albums admin view view.
 *
 * Displays thumbnails in a row of 6 span2 columns and center the
 * images. Uses the Slimbox2 script to display the images in a lightbox:
 * http://www.digitalia.be/software/slimbox2
 * Slimbox2 must be loaded as a plugin in the bootstrap file.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @subpackage    albums
 * @subpackage    albums.views
 */
echo $this->Html->css('/slimbox2/css/slimbox2', null, array('inline' => false));
echo $this->Html->script(array('/slimbox2/js/slimbox2'), array('inline' => false));
?>
<div class="row">
	<article class="page-content" id="album-contents">
		<header>
			<h1>Album: <?php echo $album['Album']['name']; ?></h1>
			<time class="date-created" datetime="<?php echo date(DATE_ATOM, strtotime($album['Album']['created'])); ?>">
				<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($album['Album']['created'])); ?>
			</time>
		</header>
		<p><?php echo $album['Album']['description']; ?></p>
	</article>
</div>
<?php
	$i = 0;
	$last = count($images) - 1;
	$images_path = 'albums/'.sprintf("%010d", $album['Album']['id']).'/';
	foreach ($images as $image):
?>
<?php
		if ($i%6 == 0):
?>
<div class="row"> <!-- start thumbnails row -->
<?php
		endif;
?>
	<div class="span2">
		<figure><?php echo $this->Html->link($this->Html->image($images_path.'thumbnails/'.$image, array('class' => 'framed image-center', 'alt' => $image, 'title' => $image)), '/img/'.$images_path.$image, array('rel' => 'lightbox-project', 'escape' => false)) ;?><figure>
	</div>
<?php
		if (($i%6 == 5) || ($i == $last)):
?>
</div> <!-- end thumbnails row -->
<?php
		endif;
?>
<?php
	$i++;
	endforeach;
?>
