<?php
/**
 * Events admin view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Events.View
 */
$year_range = Configure::read('Admin.date_select.year_range');

if (Configure::read('Admin.date_select.max_year')) $max_year = Configure::read('Admin.date_select.max_year');
else $max_year = date('Y') + $year_range;

$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Edit an Event');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Events', array('action' => 'admin_index')); ?></li>
			<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $this->Form->value('Event.id')), array('escape' => false), sprintf('Are you sure you want to delete # %s?', $this->Form->value('Event.id'))); ?></li>
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
			<fieldset>
				<legend>Current Image</legend>
				<?php echo $this->FormatImage->idImage('events/'.$this->Form->value('year'), $this->Form->value('id'), array(), 'events'); ?>
			</fieldset>
		<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
