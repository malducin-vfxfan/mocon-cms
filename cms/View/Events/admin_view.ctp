<?php
/**
 * Events admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Events
 */
$this->extend('/Common/admin_view');

$this->assign('formTitle', 'Event');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('Edit Event', array('action' => 'admin_edit', $event['Event']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete Event', array('class' => 'text-danger')), array('action' => 'admin_delete', $event['Event']['id']), array('escape' => false, 'confirm' => sprintf('Are you sure you want to delete # %s?', $event['Event']['id']))); ?> </li>
			<li><?php echo $this->Html->link('List Events', array('action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New Event', array('action' => 'admin_add')); ?> </li>
<?php
$this->end();
?>
			<dt>Id</dt>
			<dd>
				<?php echo $event['Event']['id']; ?>
				&nbsp;
			</dd>
			<dt>Name</dt>
			<dd>
				<?php echo $event['Event']['name']; ?>
				&nbsp;
			</dd>
			<dt>Date Start</dt>
			<dd>
				<?php echo $event['Event']['date_start']; ?>
				&nbsp;
			</dd>
			<dt>Date End</dt>
			<dd>
				<?php echo $event['Event']['date_end']; ?>
				&nbsp;
			</dd>
			<dt>Location</dt>
			<dd>
				<?php echo $event['Event']['location']; ?>
				&nbsp;
			</dd>
			<dt>Description</dt>
			<dd>
				<?php echo $event['Event']['description']; ?>
				&nbsp;
			</dd>
			<dt>Webpage</dt>
			<dd>
				<?php echo $event['Event']['webpage']; ?>
				&nbsp;
			</dd>
			<dt>Slug</dt>
			<dd>
				<?php echo $event['Event']['slug']; ?>
				&nbsp;
			</dd>
			<dt>Created</dt>
			<dd>
				<?php echo $event['Event']['created']; ?>
				&nbsp;
			</dd>
			<dt>Modified</dt>
			<dd>
				<?php echo $event['Event']['modified']; ?>
				&nbsp;
			</dd>
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
					foreach ($event['Event']['preview_images'] as $size => $images):
						foreach ($images as $image):
				?>
				<tr>
					<td><?php echo $this->Html->link($image, '/img/events/'.$event['Event']['year'].'/'.sprintf("%010d", $event['Event']['id']).'/'.$image, array('target' => '_blank')); ?></td>
					<td>
						<?php echo $this->Html->link('View', '/img/events/'.$event['Event']['year'].'/'.sprintf("%010d", $event['Event']['id']).'/'.$image, array('class' => 'btn btn-default', 'target' => '_blank')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_deleteFile', $event['Event']['id'], '?' => array('filename' => $image, 'redirection' => 'admin_view')), array('class' => 'btn btn-danger', 'confirm' => 'Are you sure you want to delete this image?')); ?>
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
