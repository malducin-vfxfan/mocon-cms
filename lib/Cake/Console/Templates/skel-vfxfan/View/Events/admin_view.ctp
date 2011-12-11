<?php
/**
 * Events admin view view.
 *
 * Events admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @subpackage    events
 * @subpackage    events.views.admin
 */
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('Edit Event', array('action' => 'admin_edit', $event['Event']['id']), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Form->postLink('Delete Event', array('action' => 'admin_delete', $event['Event']['id']), array('class' => 'btn danger'), sprintf('Are you sure you want to delete # %s?', $event['Event']['id'])); ?> </li>
			<li><?php echo $this->Html->link('List Events', array('action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Event', array('action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
		<h2><?php  echo 'Event';?></h2>
		<dl>
			<dt><?php echo 'Id'; ?></dt>
			<dd>
				<?php echo $event['Event']['id']; ?>
				&nbsp;
			</dd>
			<dt><?php echo 'Name'; ?></dt>
			<dd>
				<?php echo $event['Event']['name']; ?>
				&nbsp;
			</dd>
			<dt><?php echo 'Date Start'; ?></dt>
			<dd>
				<?php echo $event['Event']['date_start']; ?>
				&nbsp;
			</dd>
			<dt><?php echo 'Date End'; ?></dt>
			<dd>
				<?php echo $event['Event']['date_end']; ?>
				&nbsp;
			</dd>
			<dt><?php echo 'Location'; ?></dt>
			<dd>
				<?php echo $event['Event']['location']; ?>
				&nbsp;
			</dd>
			<dt><?php echo 'Description'; ?></dt>
			<dd>
				<?php echo $event['Event']['description']; ?>
				&nbsp;
			</dd>
			<dt><?php echo 'Webpage'; ?></dt>
			<dd>
				<?php echo $event['Event']['webpage']; ?>
				&nbsp;
			</dd>
			<dt><?php echo 'Created'; ?></dt>
			<dd>
				<?php echo $event['Event']['created']; ?>
				&nbsp;
			</dd>
			<dt><?php echo 'Modified'; ?></dt>
			<dd>
				<?php echo $event['Event']['modified']; ?>
				&nbsp;
			</dd>
			<dt>Image</dt>
			<dd>
				<?php echo $this->FormatImage->idImage('events', $event['Event']['id']); ?>
				&nbsp;
			</dd>
		</dl>
	</section>
</div>
