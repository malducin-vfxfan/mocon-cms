<?php
/**
 * Events admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Events
 */
$this->extend('/Common/admin_view');

$this->assign('formTitle', 'Event');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('Edit Event', array('action' => 'admin_edit', $event['Event']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete Event', array('class' => 'text-danger')), array('action' => 'admin_delete', $event['Event']['id']), array('escape' => false), sprintf('Are you sure you want to delete # %s?', $event['Event']['id'])); ?> </li>
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
			<dt>Image</dt>
			<dd>
				<?php echo $this->FormatImage->idImage('events/'.$event['Event']['year'].'/'.sprintf("%010d", $event['Event']['id']), $event['Event']['id'], array(), 'events'); ?>
				&nbsp;
			</dd>
