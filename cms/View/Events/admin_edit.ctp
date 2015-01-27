<?php
/**
 * Events admin view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Events
 */
$year_range = Configure::read('Admin.date_select.year_range');

if (Configure::read('Admin.date_select.max_year')) $max_year = Configure::read('Admin.date_select.max_year');
else $max_year = date('Y') + $year_range;

$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Edit an Event');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Events', array('action' => 'admin_index')); ?></li>
			<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $this->request->data('Event.id')), array('escape' => false), sprintf('Are you sure you want to delete # %s?', $this->request->data('Event.id'))); ?></li>
<?php
$this->end();
?>
		<?php
			echo $this->Form->create('Event', array(
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
				<legend>Admin Edit Event</legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
					echo $this->Form->input('date_start', array('maxYear' => $max_year));
					echo $this->Form->input('date_end', array('maxYear' => $max_year));
					echo $this->Form->input('location');
					echo $this->Form->input('description');
					echo $this->Form->input('webpage', array('type' => 'url'));
					echo $this->Form->input('slug');
					echo $this->Form->input('File.image', array('type' => 'file'));
				?>
			</fieldset>
		<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
		<h3>Dropzones</h3>
		<?php $ajaxImagesOptions = htmlspecialchars(json_encode(array('year' => $this->request->data('Event.year')))); ?>
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
					foreach ($this->request->data('Event.preview_images') as $size => $images):
						foreach ($images as $image):
				?>
				<tr>
					<td><?php echo $this->Html->link($image, '/img/events/'.$this->request->data('Event.year').'/'.sprintf("%010d", $this->request->data('Event.id')).'/'.$image, array('target' => '_blank')); ?></td>
					<td>
						<?php echo $this->Html->link('View', '/img/events/'.$this->request->data('Event.year').'/'.sprintf("%010d", $this->request->data('Event.id')).'/'.$image, array('class' => 'btn btn-default', 'target' => '_blank')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_deleteFile', $this->request->data('Event.id'), '?' => array('filename' => $image, 'redirection' => 'admin_edit')), array('class' => 'btn btn-danger'), 'Are you sure you want to delete this image?'); ?>
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
