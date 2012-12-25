<?php
/**
 * Events admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       events
 * @subpackage    events.views
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Events');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('New Event', array('action' => 'add'), array('class' => 'btn')); ?></li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id');?></th>
					<th><?php echo $this->Paginator->sort('name');?></th>
					<th><?php echo $this->Paginator->sort('date_start');?></th>
					<th><?php echo $this->Paginator->sort('created');?></th>
					<th><?php echo $this->Paginator->sort('modified');?></th>
<?php
$this->end();

$this->start('tableRows');
?>
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
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $event['Event']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $event['Event']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();
?>
