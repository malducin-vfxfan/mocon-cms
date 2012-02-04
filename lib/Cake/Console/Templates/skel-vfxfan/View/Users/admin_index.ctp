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
?>
<div class="row">
	<section class="admin-main-content">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('New User', array('action' => 'admin_add'), array('class' => 'btn')); ?></li>
		</ul>
	</section>
</div>
<div class="row">
	<section class="admin-main-content">
		<h2>Users</h2>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id');?></th>
					<th><?php echo $this->Paginator->sort('username');?></th>
					<th><?php echo $this->Paginator->sort('created');?></th>
					<th><?php echo $this->Paginator->sort('modified');?></th>
					<th><?php echo $this->Paginator->sort('group_id');?></th>
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
						<?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'admin_view', $user['Group']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link('View', array('action' => 'admin_view', $user['User']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $user['User']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $user['User']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
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
	</section>
</div>
<aside class="row">
	<div class="span12"><h2>Related Actions</h2></div>
	<section class="admin-related-actions">
		<h3>Groups Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('List Groups', array('controller' => 'groups', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Group', array('controller' => 'groups', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-related-actions">
		<h3>Posts Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('List Posts', array('controller' => 'posts', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Post', array('controller' => 'posts', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
</aside>
