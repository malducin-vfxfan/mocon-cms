<?php
/**
 * Groups admin add view.
 *
 * Groups admin add view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    groups
 */
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('List Groups', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
			<li><?php echo $this->Html->link('List Users', array('controller' => 'users', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
		<h2>Add a Group</h2>
		<?php echo $this->Form->create('Group', array('class' => 'form-stacked'));?>
			<fieldset>
				<legend>Admin Add Group</legend>
				<?php
					echo $this->Form->input('name', array('div' => 'clearfix'));
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>