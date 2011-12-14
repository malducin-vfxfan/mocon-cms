<?php
/**
 * Events admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @subpackage    events
 * @subpackage    events.views
 */
?>
<div class="row">
	<section class="admin-main-content">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('New Event', array('action' => 'add'), array('class' => 'btn')); ?></li>
		</ul>
	</section>
	<section class="admin-main-content">
		<h2>Events</h2>
		<table class="bordered-table zebra-striped">
			<tr>
				<th><?php echo $this->Paginator->sort('id');?></th>
				<th><?php echo $this->Paginator->sort('name');?></th>
				<th><?php echo $this->Paginator->sort('date_start');?></th>
				<th><?php echo $this->Paginator->sort('created');?></th>
				<th><?php echo $this->Paginator->sort('modified');?></th>
				<th>Actions</th>
			</tr>
			<?php foreach ($events as $event): ?>
			<tr>
				<td><?php echo $event['Event']['id']; ?>&nbsp;</td>
				<td><?php echo $event['Event']['name']; ?>&nbsp;</td>
				<td><?php echo $event['Event']['date_start']; ?>&nbsp;</td>
				<td><?php echo $event['Event']['created']; ?>&nbsp;</td>
				<td><?php echo $event['Event']['modified']; ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link('View', array('action' => 'admin_view', $event['Event']['id']), array('class' => 'btn')); ?>
					<?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $event['Event']['id']), array('class' => 'btn')); ?>
					<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $event['Event']['id']), array('class' => 'btn'), sprintf('Are you sure you want to delete # %s?', $event['Event']['id'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<p>
		<?php
			echo $this->Paginator->counter(array(
				'format' => 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'
			));
		?>
		</p>

		<div class="paging">
		<?php
			echo $this->Paginator->first('first');
			echo $this->Paginator->prev('« previous', array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next('next »', array(), null, array('class' => 'next disabled'));
			echo $this->Paginator->first('last');
		?>
		</div>
	</section>
</div>

