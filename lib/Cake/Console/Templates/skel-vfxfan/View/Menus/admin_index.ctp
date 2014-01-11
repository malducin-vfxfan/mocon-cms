<?php
/**
 * Menus admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Menus.View
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Menu Items');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('New Menu', array('action' => 'admin_add')); ?></li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('parent_id'); ?></th>
					<th><?php echo $this->Paginator->sort('priority'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
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
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								Action <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><?php echo $this->Html->link('View', array('action' => 'admin_view', $menu['Menu']['id'])); ?></li>
								<li><?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $menu['Menu']['id'])); ?></li>
								<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $menu['Menu']['id']), array('escape' => false), sprintf('Are you sure you want to delete # %s?', $menu['Menu']['id'])); ?></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();
?>
