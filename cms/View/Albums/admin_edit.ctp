<?php
/**
 * Albums admin view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Albums
 */
$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Edit an Album');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Albums', array('action' => 'admin_index')); ?></li>
			<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $this->request->data('Album.id')), array('escape' => false), sprintf('Are you sure you want to delete # %s?', $this->request->data('Album.id'))); ?></li>
<?php
$this->end();
?>
		<?php
			echo $this->Form->create('Album', array(
				'type' => 'file',
				'inputDefaults' => array(
					'div' => array('class' => 'form-group'),
					'class' => 'form-control',
					'error' => array(
						'attributes' => array('class' => 'text-danger')
					)
				)
			));
		?>
			<fieldset>
				<legend>Admin Edit Album</legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
					echo $this->Form->input('description');
					echo $this->Form->input('slug');
					echo $this->Form->input('File.preview_image', array('type' => 'file'));
				?>
			</fieldset>
		<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
<?php
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
					foreach ($this->request->data('Album.preview_images') as $size => $images):
						foreach ($images as $image):
				?>
				<tr>
					<td><?php echo $this->Html->link($image, '/img/albums/'.$this->request->data('Album.year').'/'.sprintf("%010d", $this->request->data('Album.id')).'/preview/'.$image, array('target' => '_blank')); ?></td>
					<td>
						<?php echo $this->Html->link('View', '/img/albums/'.$this->request->data('Album.year').'/'.sprintf("%010d", $this->request->data('Album.id')).'/preview/'.$image, array('class' => 'btn btn-default', 'target' => '_blank')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_deleteFile', $this->request->data('Album.id'), 'file_name' => $image, 'redirect_action' => 'admin_edit'), array('class' => 'btn btn-danger'), 'Are you sure you want to delete this image?'); ?>
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
