<?php
/**
 * Menus admin edit view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       menus
 * @subpackage    menus.views
 */
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $this->Form->value('Menu.id')), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $this->Form->value('Menu.id'))); ?></li>
			<li><?php echo $this->Html->link('List Menus', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
		</ul>
	</section>
	<section class="admin-content">
		<h2>Edit a Menu Item</h2>
		<?php echo $this->Form->create('Menu');?>
			<fieldset>
				<legend>Admin Edit Menu Item</legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
					echo $this->Form->input('link');
					echo $this->Form->input('parent_id');
					echo $this->Form->input('priority', array('type' => 'number', 'min' => 0));
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>
