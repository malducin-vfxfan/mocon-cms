<?php
/**
 * Albums admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Albums
 */
echo $this->Html->css('magnific-popup', array('inline' => false));
echo $this->Html->script(array('jquery.magnific-popup'), array('inline' => false));

$this->extend('/Common/admin_view');

$this->assign('formTitle', 'Album');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('Edit Album', array('action' => 'admin_edit', $album['Album']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete Album', array('class' => 'text-danger')), array('action' => 'admin_delete', $album['Album']['id']), array('escape' => false), sprintf('Are you sure you want to delete # %s?', $album['Album']['id'])); ?> </li>
			<li><?php echo $this->Html->link('List Albums', array('action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New Album', array('action' => 'admin_add')); ?> </li>
<?php
$this->end();

$this->start('relatedActions');
?>
			<li><?php echo $this->Html->link('Upload Album Image', array('action' => 'admin_uploadAlbumImage', $album['Album']['id'])); ?> </li>
<?php
$this->end();
?>
			<dt>Id</dt>
			<dd>
				<?php echo $album['Album']['id']; ?>
				&nbsp;
			</dd>
			<dt>Name</dt>
			<dd>
				<?php echo $album['Album']['name']; ?>
				&nbsp;
			</dd>
			<dt>Description</dt>
			<dd>
				<?php echo $album['Album']['description']; ?>
				&nbsp;
			</dd>
			<dt>Slug</dt>
			<dd>
				<?php echo $album['Album']['slug']; ?>
				&nbsp;
			</dd>
			<dt>Created</dt>
			<dd>
				<?php echo $album['Album']['created']; ?>
				&nbsp;
			</dd>
			<dt>Modified</dt>
			<dd>
				<?php echo $album['Album']['modified']; ?>
				&nbsp;
			</dd>
			<dt>Image</dt>
			<dd>
				<?php echo $this->FormatImage->idImage('albums/'.$album['Album']['year'], $album['Album']['id'], array('class' => 'img-thumbnail'), 'albums'); ?>
				&nbsp;
			</dd>
<?php
$this->start('contentHtml');
	$i = 0;
	$last = count($images) - 1;
	$images_path = 'albums/'.$album['Album']['year'].'/'.sprintf("%010d", $album['Album']['id']).'/';
	foreach ($images as $image):
		if ($i%6 == 0):
?>
	<div class="row"> <!-- start thumbnails row -->
<?php
		endif;
?>
		<div class="col-md-2 text-center">
			<?php echo $this->Html->link($this->Html->image($images_path.'thumbnails/'.$image, array('class' => 'img-thumbnail', 'alt' => $image, 'title' => $image)), '/img/'.$images_path.$image, array('class' => 'popup-link', 'escapeTitle' => false, 'title' => $image)) ;?>
			<p>
				<?php echo $this->Form->postLink('Delete', array('action' => 'admin_deleteAlbumImage', $album['Album']['id'], $image), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $image)); ?>
			</p>
		</div>
<?php
		if (($i%6 == 5) || ($i == $last)):
?>
	</div> <!-- end thumbnails row -->
<?php
		endif;
	$i++;
	endforeach;
$this->end();
?>
