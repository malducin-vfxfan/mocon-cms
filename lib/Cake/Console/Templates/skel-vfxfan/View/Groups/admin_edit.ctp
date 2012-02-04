<?php
/**
 * Groups admin edit view.
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
			<li><?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $this->Form->value('Group.id')), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $this->Form->value('Group.id'))); ?></li>
			<li><?php echo $this->Html->link('List Groups', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
			<li><?php echo $this->Html->link('List Users', array('controller' => 'users', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
		<h2>Edit a Group</h2>
		<?php echo $this->Form->create('Group');?>
			<fieldset>
				<legend>Admin Edit Group</legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>
