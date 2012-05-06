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
?>
<div class="row">
	<section class="admin-main-content">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('New Group', array('action' => 'admin_add'), array('class' => 'btn')); ?></li>
		</ul>
	</section>
</div>
<div class="row">
	<section class="admin-main-content">
		<h2>Groups</h2>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id');?></th>
					<th><?php echo $this->Paginator->sort('name');?></th>
					<th><?php echo $this->Paginator->sort('created');?></th>
					<th><?php echo $this->Paginator->sort('modified');?></th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
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
			echo $this->Paginator->prev('« previous', array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => '', 'first' => 'first', 'last' => 'last'));
			echo $this->Paginator->next('next »', array(), null, array('class' => 'next disabled'));
		?>
		</div>
	</section>
</div>
<aside class="row">
	<section class="admin-related-actions">
		<h3>User Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('List Users', array('controller' => 'users', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
</aside>
