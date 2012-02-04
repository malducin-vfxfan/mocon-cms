<?php
/**
 * Groups admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       groups
 * @subpackage    groups.views
 */
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('Edit Group', array('action' => 'admin_edit', $group['Group']['id']), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Form->postLink('Delete Group', array('action' => 'admin_delete', $group['Group']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $group['Group']['id'])); ?> </li>
			<li><?php echo $this->Html->link('List Groups', array('action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Group', array('action' => 'admin_add'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('List Users', array('controller' => 'users', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
	<h2>Group</h2>
		<dl>
			<dt>Id</dt>
			<dd>
				<?php echo $group['Group']['id']; ?>
				&nbsp;
			</dd>
			<dt>Name</dt>
			<dd>
				<?php echo $group['Group']['name']; ?>
				&nbsp;
			</dd>
			<dt>Created</dt>
			<dd>
				<?php echo $group['Group']['created']; ?>
				&nbsp;
			</dd>
			<dt>Modified</dt>
			<dd>
				<?php echo $group['Group']['modified']; ?>
				&nbsp;
			</dd>
		</dl>
	</section>
</div>
<div class="row">
	<aside class="admin-related">
		<h3>Related Users</h3>
		<?php if (!empty($users)): ?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id');?></th>
					<th><?php echo $this->Paginator->sort('username');?></th>
					<th><?php echo $this->Paginator->sort('created');?></th>
					<th><?php echo $this->Paginator->sort('modified');?></th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($users as $user): ?>
			<tr>
				<td><?php echo $user['User']['id']; ?>&nbsp;</td>
				<td><?php echo $user['User']['username']; ?>&nbsp;</td>
				<td><?php echo $user['User']['created']; ?>&nbsp;</td>
				<td><?php echo $user['User']['modified']; ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link('View', array('action' => 'admin_view', $user['User']['id']), array('class' => 'btn')); ?>
					<?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $user['User']['id']), array('class' => 'btn')); ?>
					<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $user['User']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
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
				<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add'), array('class' => 'btn'));?> </li>
			</ul>
		</section>
	</aside>
</div>
