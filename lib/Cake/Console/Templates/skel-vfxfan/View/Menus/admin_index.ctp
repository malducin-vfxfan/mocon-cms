<?php
/**
 * Menus admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       menus
 * @subpackage    menus.views
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Menu Items');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('New Menu', array('action' => 'admin_add'), array('class' => 'btn')); ?></li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id');?></th>
					<th><?php echo $this->Paginator->sort('name');?></th>
					<th><?php echo $this->Paginator->sort('parent_id');?></th>
					<th><?php echo $this->Paginator->sort('priority');?></th>
					<th><?php echo $this->Paginator->sort('created');?></th>
					<th><?php echo $this->Paginator->sort('modified');?></th>
<?php
$this->end();

$this->start('tableRows');
?>
				<?php foreach ($menus as $menu): ?>
				<tr>
					<td><?php echo $menu['Menu']['id']; ?>&nbsp;</td>
					<td><?php echo $menu['Menu']['name']; ?>&nbsp;</td>
					<td><?php echo $menu['Menu']['parent_id']; ?>&nbsp;</td>
					<td><?php echo $menu['Menu']['priority']; ?>&nbsp;</td>
					<td><?php echo $menu['Menu']['created']; ?>&nbsp;</td>
					<td><?php echo $menu['Menu']['modified']; ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link('View', array('action' => 'admin_view', $menu['Menu']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $menu['Menu']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $menu['Menu']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $menu['Menu']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();
?>
