<?php
/**
 * Events admin view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @subpackage    events
 * @subpackage    events.views
 */
$year_range = Configure::read('Admin.date_select.year_range');

if (Configure::read('Admin.date_select.max_year')) $max_year = Configure::read('Admin.date_select.max_year');
else $max_year = date('Y') + $year_range;
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $this->Form->value('Event.id')), array('class' => 'btn danger'), sprintf('Are you sure you want to delete # %s?', $this->Form->value('Event.id'))); ?></li>
			<li><?php echo $this->Html->link('List Events', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
		</ul>
	</section>
	<section class="admin-content">
		<h2>Admin Edit an Event</h2>
		<?php echo $this->Form->create('Event', array('class' => 'form-stacked', 'type' => 'file'));?>
			<fieldset>
				<legend>Admin Edit Event</legend>
				<?php
					echo $this->Form->input('id', array('div' => 'clearfix'));
					echo $this->Form->input('name', array('div' => 'clearfix'));
					echo $this->Form->input('date_start', array('div' => 'clearfix', 'maxYear' => $max_year));
					echo $this->Form->input('date_end', array('div' => 'clearfix', 'maxYear' => $max_year));
					echo $this->Form->input('location', array('div' => 'clearfix'));
					echo $this->Form->input('description', array('div' => 'clearfix'));
					echo $this->Form->input('webpage', array('div' => 'clearfix', 'type' => 'url'));
					echo $this->Form->input('File.image', array('div' => 'clearfix', 'type' => 'file'));
				?>
			</fieldset>
			<fieldset>
				<legend>Current Image</legend>
				<?php echo $this->FormatImage->idImage('events/'.$this->Form->value('year'), $this->Form->value('id'), array(), 'events'); ?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>
