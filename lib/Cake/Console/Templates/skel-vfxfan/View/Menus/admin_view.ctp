<?php
/**
 * Menus admin view view.
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
			<li><?php echo $this->Html->link('Edit Menu', array('action' => 'admin_edit', $menu['Menu']['id']), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Form->postLink('Delete Menu', array('action' => 'admin_delete', $menu['Menu']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $menu['Menu']['id'])); ?> </li>
			<li><?php echo $this->Html->link('List Menus', array('action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Menu', array('action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
	<h2>Menu</h2>
		<dl>
			<dt>Id</dt>
			<dd>
				<?php echo $menu['Menu']['id']; ?>
				&nbsp;
			</dd>
			<dt>Name</dt>
			<dd>
				<?php echo $menu['Menu']['name']; ?>
				&nbsp;
			</dd>
			<dt>Link</dt>
			<dd>
				<?php echo $menu['Menu']['link']; ?>
				&nbsp;
			</dd>
			<dt>Parent Id</dt>
			<dd>
				<?php echo $menu['Menu']['parent_id']; ?>
				&nbsp;
			</dd>
			<dt>Priority</dt>
			<dd>
				<?php echo $menu['Menu']['priority']; ?>
				&nbsp;
			</dd>
			<dt>Created</dt>
			<dd>
				<?php echo $menu['Menu']['created']; ?>
				&nbsp;
			</dd>
			<dt>Modified</dt>
			<dd>
				<?php echo $menu['Menu']['modified']; ?>
				&nbsp;
			</dd>
		</dl>
	</section>
</div>
