<?php
/**
 * ACL Permissions admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       acl_permissions
 * @subpackage    acl_permissions.views
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'ACO Permissions: '.$completePath.' ('.$aco_id.')');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('ACO Update', array('action' => 'admin_aco_update'), array('class' => 'btn')); ?></li>
			<li><?php echo $this->Html->link('List ACOs', array('action' => 'admin_index'), array('class' => 'btn')); ?></li>
			<li><?php echo $this->Html->link('List Groups', array('controller' => 'groups', 'action' => 'admin_index'), array('class' => 'btn')); ?></li>
			<li><?php echo $this->Html->link('List User', array('controller' => 'users', 'action' => 'admin_indexe'), array('class' => 'btn')); ?></li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th>User Id</th>
					<th>User</th>
					<th>Group Id</th>
					<th>Group</th>
<?php
$this->end();

$this->start('tableRows');
?>
				<?php foreach ($users as $user): ?>
				<tr>
					<td><?php echo $user['User']['id']; ?></td>
					<td>
						<?php echo $user['User']['username']; ?>
						<?php if ($user['User']['permission']): ?>
						<span class="label label-success">Access Permitted</span>
						<?php else: ?>
						<span class="label label-important">Access Denied</span>
						<?php endif; ?>
					</td>
					<td><?php echo $user['Group']['id']; ?></td>
					<td>
						<?php echo $user['Group']['name']; ?>
						<?php if ($user['Group']['permission']): ?>
						<span class="label label-success">Access Permitted</span>
						<?php else: ?>
						<span class="label label-important">Access Denied</span>
						<?php endif; ?>
					</td>
					<td>
						<?php echo $this->Form->postLink('Switch User Permissions', array('action' => 'admin_edit', $aco_id, 'User', $user['User']['id']), array('class' => 'btn btn-primary'), 'Are you sure you want to change the permissions?'); ?>
						<?php echo $this->Form->postLink('Delete User Permissions', array('action' => 'admin_delete', $aco_id, 'User', $user['User']['id']), array('class' => 'btn btn-danger'), 'Are you sure you want to delete this permission?'); ?>
						<?php echo $this->Form->postLink('Switch Group Permissions', array('action' => 'admin_edit', $aco_id, 'Group', $user['Group']['id']), array('class' => 'btn btn-primary'), 'Are you sure you want to change the permissions?'); ?>
						<?php echo $this->Form->postLink('Delete Group Permissions', array('action' => 'admin_delete', $aco_id, 'Group', $user['Group']['id']), array('class' => 'btn btn-danger'), 'Are you sure you want to delete this permission?'); ?>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();
?>
