<?php
/**
 * Users admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       users
 * @subpackage    users.views
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Users');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('New User', array('action' => 'admin_add'), array('class' => 'btn')); ?></li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id');?></th>
					<th><?php echo $this->Paginator->sort('username');?></th>
					<th><?php echo $this->Paginator->sort('created');?></th>
					<th><?php echo $this->Paginator->sort('modified');?></th>
					<th><?php echo $this->Paginator->sort('group_id');?></th>
<?php
$this->end();

$this->start('tableRows');
?>
				<?php foreach ($users as $user): ?>
				<tr>
					<td><?php echo $user['User']['id']; ?>&nbsp;</td>
					<td><?php echo $user['User']['username']; ?>&nbsp;</td>
					<td><?php echo $user['User']['created']; ?>&nbsp;</td>
					<td><?php echo $user['User']['modified']; ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'admin_view', $user['Group']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link('View', array('action' => 'admin_view', $user['User']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $user['User']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $user['User']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
					</td>
				</tr>
			<?php endforeach; ?>
<?php
$this->end();

$this->start('relatedActions1');
?>
			<li><?php echo $this->Html->link('List Groups', array('controller' => 'groups', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Group', array('controller' => 'groups', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
<?php
$this->end();

$this->start('relatedActions2');
?>
			<li><?php echo $this->Html->link('List Posts', array('controller' => 'posts', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Post', array('controller' => 'posts', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
<?php
$this->end();
?>
