<?php
/**
 * Posts admin edit view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Posts
 */
if (Configure::read('TinyMCE.active')) {
	echo $this->element('TinyMCE/config_basic');
}

$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Edit a Post');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Posts', array('action' => 'admin_index')); ?></li>
			<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $this->request->data('Post.id')), array('escape' => false), sprintf('Are you sure you want to delete # %s?', $this->request->data('Post.id'))); ?></li>
<?php
$this->end();

$this->start('relatedActions');
?>
			<li><?php echo $this->Html->link('List Users', array('controller' => 'users', 'action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add')); ?> </li>
<?php
$this->end();
?>
		<?php
			echo $this->Form->create('Post', array(
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
				<legend>Admin Edit Post</legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('title');
					echo $this->Form->input('summary');
					echo $this->Form->input('content');
					echo $this->Form->input('slug');
					echo $this->Form->input('File.image', array('type' => 'file'));
					echo $this->Form->hidden('user_id');
				?>
			</fieldset>
		<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
		<h3>Dropzones</h3>
		<?php $ajaxImagesOptions = htmlspecialchars(json_encode(array('year' => $this->request->data('Post.year')))); ?>
		<h4>Preview Images (No Conversions)</h4>
		<div class="dropzone" id="dropzone-preview-images" data-base="<?php echo $this->request->base; ?>" data-controller="<?php echo $this->request->controller; ?>" data-id="<?php echo $this->request->params['pass'][0]; ?>" data-upload-type="preview-images" data-options='<?php echo $ajaxImagesOptions; ?>'><span class="fa fa-file-image-o"></span> Just drag and drop images here</div>
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
					foreach ($this->request->data('Post.preview_images') as $size => $images):
						foreach ($images as $image):
				?>
				<tr>
					<td><?php echo $this->Html->link($image, '/img/posts/'.$this->request->data('Post.year').'/'.sprintf("%010d", $this->request->data('Post.id')).'/'.$image, array('target' => '_blank')); ?></td>
					<td>
						<?php echo $this->Html->link('View', '/img/posts/'.$this->request->data('Post.year').'/'.sprintf("%010d", $this->request->data('Post.id')).'/'.$image, array('class' => 'btn btn-default', 'target' => '_blank')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_deleteFile', $this->request->data('Post.id'), 'file_name' => $image, 'redirect_action' => 'admin_edit'), array('class' => 'btn btn-danger'), 'Are you sure you want to delete this image?'); ?>
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
