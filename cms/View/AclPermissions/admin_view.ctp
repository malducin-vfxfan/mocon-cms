<?php
/**
 * ACL Permissions admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.AclPermissions
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'ACO Permissions: '.$completePath.' (ACO Id: '.$aco_id.')');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('ACO Update', array('action' => 'admin_aco_update')); ?></li>
			<li><?php echo $this->Html->link('List ACOs', array('action' => 'admin_index')); ?></li>
<?php
$this->end();

$this->start('relatedActions');
?>
			<li><?php echo $this->Html->link('List Groups', array('controller' => 'groups', 'action' => 'admin_index')); ?></li>
			<li><?php echo $this->Html->link('List User', array('controller' => 'users', 'action' => 'admin_index')); ?></li>
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
						<span class="label label-danger">Access Denied</span>
						<?php endif; ?>
					</td>
					<td><?php echo $user['Group']['id']; ?></td>
					<td>
						<?php echo $user['Group']['name']; ?>
						<?php if ($user['Group']['permission']): ?>
						<span class="label label-success">Access Permitted</span>
						<?php else: ?>
						<span class="label label-danger">Access Denied</span>
						<?php endif; ?>
					</td>
					<td>
						<div class="btn-group">
 							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								Action <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Switch User Permissions', array('class' => 'text-info')), array('action' => 'admin_edit', $aco_id, 'User', $user['User']['id']), array('escape' => false, 'confirm' => 'Are you sure you want to change the permissions?')); ?></li>
								<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete User Permissions', array('class' => 'text-danger')), array('action' => 'admin_delete', $aco_id, 'User', $user['User']['id']), array('escape' => false, 'confirm' => 'Are you sure you want to delete this permission?')); ?></li>
								<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Switch Group Permissions', array('class' => 'text-info')), array('action' => 'admin_edit', $aco_id, 'Group', $user['Group']['id']), array('escape' => false, 'confirm' => 'Are you sure you want to change the permissions?')); ?></li>
								<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete Group Permissions', array('class' => 'text-danger')), array('action' => 'admin_delete', $aco_id, 'Group', $user['Group']['id']), array('escape' => false, 'confirm' => 'Are you sure you want to delete this permission?')); ?></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();
?>
