<?php
/**
 * Menus admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Menus.View
 */
$this->extend('/Common/admin_view');

$this->assign('formTitle', 'Menu Item');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('Edit Menu', array('action' => 'admin_edit', $menu['Menu']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete Menu', array('class' => 'text-danger')), array('action' => 'admin_delete', $menu['Menu']['id']), array('escape' => false), sprintf('Are you sure you want to delete # %s?', $menu['Menu']['id'])); ?> </li>
			<li><?php echo $this->Html->link('List Menus', array('action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New Menu', array('action' => 'admin_add')); ?> </li>
<?php
$this->end();
?>
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
