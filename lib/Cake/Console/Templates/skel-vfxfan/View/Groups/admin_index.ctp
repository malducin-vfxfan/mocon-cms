<?php
/**
 * Groups admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       groups
 * @subpackage    groups.views
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Groups');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('New Group', array('action' => 'admin_add'), array('class' => 'btn')); ?></li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id');?></th>
					<th><?php echo $this->Paginator->sort('name');?></th>
					<th><?php echo $this->Paginator->sort('created');?></th>
					<th><?php echo $this->Paginator->sort('modified');?></th>
<?php
$this->end();

$this->start('tableRows');
?>
				<?php foreach ($groups as $group): ?>
				<tr>
					<td><?php echo $group['Group']['id']; ?>&nbsp;</td>
					<td><?php echo $group['Group']['name']; ?>&nbsp;</td>
					<td><?php echo $group['Group']['created']; ?>&nbsp;</td>
					<td><?php echo $group['Group']['modified']; ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link('View', array('action' => 'admin_view', $group['Group']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $group['Group']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $group['Group']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $group['Group']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();

$this->start('relatedActions1');
?>
			<li><?php echo $this->Html->link('List Users', array('controller' => 'users', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
<?php
$this->end();
?>
