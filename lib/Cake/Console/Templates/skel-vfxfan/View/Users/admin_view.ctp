<?php
/**
 * Users admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       users
 * @subpackage    users.views
 */
?>
<div class="row">
<section class="admin-actions">
	<h3>Actions</h3>
	<ul class="action-buttons-list">
		<li><?php echo $this->Html->link('Edit User', array('action' => 'admin_edit', $user['User']['id']), array('class' => 'btn')); ?> </li>
		<li><?php echo $this->Form->postLink('Delete User', array('action' => 'admin_delete', $user['User']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link('List Users', array('action' => 'admin_index'), array('class' => 'btn')); ?> </li>
		<li><?php echo $this->Html->link('New User', array('action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		<li><?php echo $this->Html->link('List Groups', array('controller' => 'groups', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
		<li><?php echo $this->Html->link('New Group', array('controller' => 'groups', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		<li><?php echo $this->Html->link('List Posts', array('controller' => 'posts', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
		<li><?php echo $this->Html->link('New Post', array('controller' => 'posts', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
	</ul>
</section>
<section class="admin-content">
<h2>User</h2>
	<dl>
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
	</dl>
</section>
</div>
<div class="row">
	<aside class="admin-related">
		<h3>Related Posts</h3>
		<?php if (!empty($posts)): ?>
		<table class="table table-striped table-bordered">
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
						<?php echo $this->Html->link('View', array('controller' => 'posts', 'action' => 'admin_view', $post['Post']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Html->link('Edit', array('controller' => 'posts', 'action' => 'admin_edit', $post['Post']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink('Delete', array('controller' => 'posts', 'action' => 'admin_delete', $post['Post']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $post['Post']['id'])); ?>
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

		<div class="paging">
		<?php
			echo $this->Paginator->first('first');
			echo $this->Paginator->prev('« previous', array(), null, array('class' => 'disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next('next »', array(), null, array('class' => 'disabled'));
			echo $this->Paginator->last('last');
		?>
		</div>
		<?php endif; ?>

		<section class="admin-view-related-actions">
			<h4>Related Actions</h4>
			<ul class="action-buttons-list">
				<li><?php echo $this->Html->link('New Post', array('controller' => 'posts', 'action' => 'admin_add'), array('class' => 'btn'));?> </li>
			</ul>
		</section>
	</aside>
</div>