<?php
/**
 * Pages admin index view.
 *
 * Pages admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    pages
 */
?>
<div class="row">
	<section class="admin-main-content">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('New Page', array('action' => 'admin_add'), array('class' => 'btn')); ?></li>
		</ul>
	</section>
</div>
<div class="row">
	<section class="admin-main-content">
		<h2>Pages</h2>
		<table class="bordered-table zebra-striped">
			<tr>
				<th><?php echo $this->Paginator->sort('id');?></th>
				<th><?php echo $this->Paginator->sort('title');?></th>
				<th><?php echo $this->Paginator->sort('slug');?></th>
				<th><?php echo $this->Paginator->sort('created');?></th>
				<th><?php echo $this->Paginator->sort('modified');?></th>
				<th>Actions</th>
			</tr>
			<?php foreach ($pages as $page): ?>
			<tr>
				<td><?php echo $page['Page']['id']; ?>&nbsp;</td>
				<td><?php echo $page['Page']['title']; ?>&nbsp;</td>
				<td><?php echo $page['Page']['slug']; ?>&nbsp;</td>
				<td><?php echo $page['Page']['created']; ?>&nbsp;</td>
				<td><?php echo $page['Page']['modified']; ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link('View', array('action' => 'admin_view', $page['Page']['id']), array('class' => 'btn')); ?>
					<?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $page['Page']['id']), array('class' => 'btn')); ?>
					<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $page['Page']['id']), array('class' => 'btn danger'), sprintf('Are you sure you want to delete # %s?', $page['Page']['id'])); ?>
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
<aside class="row">
	<div class="span12"><h2>Related Actions</h2></div>
	<section class="admin-related-actions">
		<h3>Page Section Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('List Page Sections', array('controller' => 'page_sections', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Page Section', array('controller' => 'page_sections', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
</aside>
