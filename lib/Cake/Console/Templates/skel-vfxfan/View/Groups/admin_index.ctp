<?php
/**
 * Groups admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Groups.View
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Groups');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('New Group', array('action' => 'admin_add')); ?></li>
<?php
$this->end();

$this->start('relatedActions');
?>
			<li><?php echo $this->Html->link('List Users', array('controller' => 'users', 'action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add')); ?> </li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
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
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								Action <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><?php echo $this->Html->link('View', array('action' => 'admin_view', $group['Group']['id'])); ?></li>
								<li><?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $group['Group']['id'])); ?></li>
								<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $group['Group']['id']), array('escape' => false), sprintf('Are you sure you want to delete # %s?', $group['Group']['id'])); ?></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();
?>
