<?php
/**
 * Menus admin edit view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.Menus
 */
$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Edit a Menu Item');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Menus', array('action' => 'admin_index')); ?></li>
			<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $this->request->data('Menu.id')), array('escape' => false, 'confirm' => sprintf('Are you sure you want to delete # %s?', $this->request->data('Menu.id')))); ?></li>
<?php
$this->end();
?>
		<?php
			echo $this->Form->create('Menu', array(
				'inputDefaults' => array(
					'div' => array('class' => 'form-group'),
					'class' => 'form-control',
					'error' => array(
						'attributes' => array('class' => 'text-danger')
					)
				)
			));
		?>
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
		<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
<?php
$this->start('relatedContent');
?>
		<h3>Pages</h3>
		<?php if (!empty($pages)): ?>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Id</th>
					<th>Title</th>
					<th>Slug</th>
					<th>Created</th>
					<th>Modified</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($pages as $page): ?>
				<tr>
					<td><?php echo $page['Page']['id'];?></td>
					<td><?php echo $page['Page']['title'];?></td>
					<td><?php echo $page['Page']['slug'];?></td>
					<td><?php echo $page['Page']['created'];?></td>
					<td><?php echo $page['Page']['modified'];?></td>
					<td>
						<?php echo $this->Html->link('Add Slug to Link', '#', array('class' => 'btn btn-info menu-page-slug', 'id' => $page['Page']['slug'])); ?>
						<?php echo $this->Html->link('View', array('controller' => 'pages', 'action' => 'admin_view', $page['Page']['id']), array('class' => 'btn btn-default')); ?>
						<?php echo $this->Html->link('Edit', array('controller' => 'pages', 'action' => 'admin_edit', $page['Page']['id']), array('class' => 'btn btn-default')); ?>
						<?php echo $this->Form->postLink('Delete', array('controller' => 'pages', 'action' => 'admin_delete', $page['Page']['id']), array('class' => 'btn btn-danger', 'confirm' => sprintf('Are you sure you want to delete # %s?', $page['Page']['id']))); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
<?php
$this->end();
?>
