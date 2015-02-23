<?php
/**
 * Users admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.Users
 */
$this->extend('/Common/admin_view');

$this->assign('formTitle', 'User');

$this->start('actions');
?>
		<li><?php echo $this->Html->link('Edit User', array('action' => 'admin_edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete User', array('class' => 'text-danger')), array('action' => 'admin_delete', $user['User']['id']), array('escape' => false, 'confirm' => sprintf('Are you sure you want to delete # %s?', $user['User']['id']))); ?> </li>
		<li><?php echo $this->Html->link('List Users', array('action' => 'admin_index')); ?> </li>
		<li><?php echo $this->Html->link('New User', array('action' => 'admin_add')); ?> </li>
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
?>
		<dt>Id</dt>
		<dd>
			<?php echo $user['User']['id']; ?>
			&nbsp;
		</dd>
		<dt>Username</dt>
		<dd>
			<?php echo $user['User']['username']; ?>
			&nbsp;
		</dd>
		<dt>Password</dt>
		<dd>
			<?php echo $user['User']['password']; ?>
			&nbsp;
		</dd>
		<dt>Created</dt>
		<dd>
			<?php echo $user['User']['created']; ?>
			&nbsp;
		</dd>
		<dt>Modified</dt>
		<dd>
			<?php echo $user['User']['modified']; ?>
			&nbsp;
		</dd>
		<dt>Group</dt>
		<dd>
			<?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'admin_view', $user['Group']['id'])); ?>
			&nbsp;
		</dd>
<?php
$this->start('relatedContent');
?>
		<div class="btn-group pull-right">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				Related Actions <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><?php echo $this->Html->link('New Post', array('controller' => 'posts', 'action' => 'admin_add')); ?></li>
			</ul>
		</div>
		<h3>Related Posts</h3>
		<?php if (!empty($posts)): ?>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Id</th>
					<th>Title</th>
					<th>Created</th>
					<th>Modified</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($posts as $post): ?>
				<tr>
					<td><?php echo $post['Post']['id'];?></td>
					<td><?php echo $post['Post']['title'];?></td>
					<td><?php echo $post['Post']['created'];?></td>
					<td><?php echo $post['Post']['modified'];?></td>
					<td>
						<?php echo $this->Html->link('View', array('controller' => 'posts', 'action' => 'admin_view', $post['Post']['id']), array('class' => 'btn btn-default')); ?>
						<?php echo $this->Html->link('Edit', array('controller' => 'posts', 'action' => 'admin_edit', $post['Post']['id']), array('class' => 'btn btn-default')); ?>
						<?php echo $this->Form->postLink('Delete', array('controller' => 'posts', 'action' => 'admin_delete', $post['Post']['id']), array('class' => 'btn btn-danger', 'confirm' => sprintf('Are you sure you want to delete # %s?', $post['Post']['id']))); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<p>
		<?php
			echo $this->Paginator->counter(array(
				'format' => 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'
			));
		?>
		</p>

		<ul class="pagination">
		<?php
			echo $this->Paginator->prev('« previous', array('tag' => 'li', 'disabledTag' => 'span'), null, array());
			echo $this->Paginator->numbers(array('separator' => '', 'first' => 'first', 'last' => 'last', 'tag' => 'li', 'currentTag' => 'span', 'currentClass' => 'active'));
			echo $this->Paginator->next('next »', array('tag' => 'li', 'disabledTag' => 'span'), null, array());
		?>
		</ul>

		<?php endif; ?>
<?php
$this->end();
?>
