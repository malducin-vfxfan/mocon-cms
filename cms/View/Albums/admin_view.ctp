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
echo $this->Html->script(array('jquery.magnific-popup', 'admin-lightbox.min'), array('inline' => false));

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
			<dt>Images Folder</dt>
			<dd>
				/img/albums/<?php echo $album['Album']['year']; ?>/<?php echo sprintf("%010d", $album['Album']['id']); ?>
				&nbsp;
			</dd>
<?php
$this->start('contentHtml');
	$i = 0;
	$last = count($images) - 1;
	$images_path = 'albums/'.$album['Album']['year'].'/'.sprintf("%010d", $album['Album']['id']).'/';
	foreach ($images as $image):
		if ($i%4 == 0):
?>
	<div class="row"> <!-- start thumbnails row -->
<?php
		endif;
?>
		<div class="col-md-3 text-center">
			<?php echo $this->Html->link($this->Html->image($images_path.'thumbnails/'.$image, array('class' => 'img-thumbnail', 'alt' => $image, 'title' => $image)), '/img/'.$images_path.$image, array('class' => 'popup-link', 'escapeTitle' => false, 'title' => $image)) ;?>
			<p>
				<?php echo $this->Form->postLink('Delete', array('action' => 'admin_deleteAlbumImage', $album['Album']['id'], $image), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $image)); ?>
			</p>
		</div>
<?php
		if (($i%4 == 3) || ($i == $last)):
?>
	</div> <!-- end thumbnails row -->
<?php
		endif;
	$i++;
	endforeach;
$this->end();

$this->start('relatedContent');
?>
		<h3>Preview Images</h3>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Filename</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($album['Album']['preview_images'] as $size => $images):
						foreach ($images as $image):
				?>
				<tr>
					<td><?php echo $this->Html->link($image, '/img/albums/'.$album['Album']['year'].'/'.sprintf("%010d", $album['Album']['id']).'/preview/'.$image, array('target' => '_blank')); ?></td>
					<td>
						<?php echo $this->Html->link('View', '/img/albums/'.$album['Album']['year'].'/'.sprintf("%010d", $album['Album']['id']).'/preview/'.$image, array('class' => 'btn btn-default', 'target' => '_blank')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_deleteFile', $album['Album']['id'], 'file_name' => $image, 'redirect_action' => 'admin_edit'), array('class' => 'btn btn-danger'), 'Are you sure you want to delete this image?'); ?>
					</td>
				</tr>
				<?php
						endforeach;
					endforeach;
				?>
			</tbody>
		</table>

<?php
$this->end();
?>
