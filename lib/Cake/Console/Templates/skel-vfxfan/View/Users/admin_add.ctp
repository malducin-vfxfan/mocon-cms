<?php
/**
 * Users admin add view.
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
			<li><?php echo $this->Html->link('List Users', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
			<li><?php echo $this->Html->link('List Groups', array('controller' => 'groups', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Group', array('controller' => 'groups', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('List Posts', array('controller' => 'posts', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Post', array('controller' => 'posts', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
		<h2>Add a User</h2>
		<?php echo $this->Form->create('User');?>
			<fieldset>
				<legend>Admin Add User</legend>
				<?php
					echo $this->Form->input('username');
					echo $this->Form->input('password');
					echo $this->Form->input('group_id');
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>
