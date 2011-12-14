<?php
/**
 * Albums admin view view.
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
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('Edit Album', array('action' => 'admin_edit', $album['Album']['id']), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Form->postLink('Delete Album', array('action' => 'admin_delete', $album['Album']['id']), array('class' => 'btn danger'), sprintf('Are you sure you want to delete # %s?', $album['Album']['id'])); ?> </li>
			<li><?php echo $this->Html->link('List Albums', array('action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Album', array('action' => 'admin_add'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('Upload Album Image', array('action' => 'admin_uploadAlbumImage', $album['Album']['id']), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
		<h2><?php  echo 'Album';?></h2>
		<dl>
			<dt><?php echo 'Id'; ?></dt>
			<dd>
				<?php echo $album['Album']['id']; ?>
				&nbsp;
			</dd>
			<dt><?php echo 'Name'; ?></dt>
			<dd>
				<?php echo $album['Album']['name']; ?>
				&nbsp;
			</dd>
			<dt><?php echo 'Description'; ?></dt>
			<dd>
				<?php echo $album['Album']['description']; ?>
				&nbsp;
			</dd>
			<dt><?php echo 'Slug'; ?></dt>
			<dd>
				<?php echo $album['Album']['slug']; ?>
				&nbsp;
			</dd>
			<dt><?php echo 'Created'; ?></dt>
			<dd>
				<?php echo $album['Album']['created']; ?>
				&nbsp;
			</dd>
			<dt><?php echo 'Modified'; ?></dt>
			<dd>
				<?php echo $album['Album']['modified']; ?>
				&nbsp;
			</dd>
			<dt>Image</dt>
			<dd>
				<?php echo $this->FormatImage->idImage('albums', $album['Album']['id']); ?>
				&nbsp;
			</dd>
		</dl>
	</section>
</div>
<section>
	<h3>Album Images</h3>
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
			<div>
				<?php echo $this->Form->postLink('Delete', array('action' => 'admin_deleteAlbumImage', $album['Album']['id'], $image), array('class' => 'btn danger'), sprintf('Are you sure you want to delete # %s?', $image)); ?>
			</div>
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
</section>