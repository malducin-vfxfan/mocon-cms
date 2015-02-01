<?php
/**
 * Users admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Users
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Users');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('New User', array('action' => 'admin_add')); ?></li>
<?php
$this->end();

$this->start('relatedActions');
?>
			<li><?php echo $this->Html->link('List Groups', array('controller' => 'groups', 'action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New Group', array('controller' => 'groups', 'action' => 'admin_add')); ?> </li>
			<li><?php echo $this->Html->link('List Posts', array('controller' => 'posts', 'action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New Post', array('controller' => 'posts', 'action' => 'admin_add')); ?> </li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('username'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
					<th><?php echo $this->Paginator->sort('group_id'); ?></th>
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
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								Action <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><?php echo $this->Html->link('View', array('action' => 'admin_view', $user['User']['id'])); ?></li>
								<li><?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $user['User']['id'])); ?></li>
								<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $user['User']['id']), array('escape' => false, 'confirm' => sprintf('Are you sure you want to delete # %s?', $user['User']['id']))); ?></li>
							</ul>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
<?php
$this->end();
?>
