<?php
/**
 * Menus admin index view.
 *
 * Menus admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    menus
 */
?>
<div class="row">
	<section class="admin-main-content">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('New Menu', array('action' => 'admin_add'), array('class' => 'btn')); ?></li>
		</ul>
	</section>
</div>
<div class="row">
	<section class="admin-main-content">
		<h2>Menus</h2>
		<table class="bordered-table zebra-striped">
			<tr>
				<th><?php echo $this->Paginator->sort('id');?></th>
				<th><?php echo $this->Paginator->sort('name');?></th>
				<th><?php echo $this->Paginator->sort('parent_id');?></th>
				<th><?php echo $this->Paginator->sort('priority');?></th>
				<th><?php echo $this->Paginator->sort('created');?></th>
				<th><?php echo $this->Paginator->sort('modified');?></th>
				<th>Actions</th>
			</tr>
		<?php
			foreach ($menus as $menu):
		?>
			<tr>
				<td><?php echo h($menu['Menu']['id']); ?>&nbsp;</td>
				<td><?php echo h($menu['Menu']['name']); ?>&nbsp;</td>
				<td><?php echo h($menu['Menu']['parent_id']); ?>&nbsp;</td>
				<td><?php echo h($menu['Menu']['priority']); ?>&nbsp;</td>
				<td><?php echo h($menu['Menu']['created']); ?>&nbsp;</td>
				<td><?php echo h($menu['Menu']['modified']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link('View', array('action' => 'admin_view', $menu['Menu']['id']), array('class' => 'btn')); ?>
					<?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $menu['Menu']['id']), array('class' => 'btn')); ?>
					<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $menu['Menu']['id']), array('class' => 'btn danger'), sprintf('Are you sure you want to delete # %s?', $menu['Menu']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
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
			echo $this->Paginator->first('first');
			echo $this->Paginator->prev('« previous', array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next('next »', array(), null, array('class' => 'next disabled'));
			echo $this->Paginator->last('last');
		?>
		</div>
	</section>
</div>
