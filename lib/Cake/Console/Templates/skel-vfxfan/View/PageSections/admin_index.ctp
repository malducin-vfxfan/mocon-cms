<?php
/**
 * Page Sections admin index view.
 *
 * Page Sections admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    page_sections
 */
?>
<div class="row">
	<section class="admin-main-content">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('New Page Section', array('action' => 'admin_add'), array('class' => 'btn')); ?></li>
		</ul>
	</section>
</div>
<div class="row">
	<section class="admin-main-content">
		<h2>Page Sections</h2>
		<table  class="bordered-table zebra-striped">
			<tr>
				<th><?php echo $this->Paginator->sort('id');?></th>
				<th><?php echo $this->Paginator->sort('title');?></th>
				<th><?php echo $this->Paginator->sort('page_id');?></th>
				<th><?php echo $this->Paginator->sort('created');?></th>
				<th><?php echo $this->Paginator->sort('modified');?></th>
				<th>Actions</th>
			</tr>
			<?php foreach ($pageSections as $pageSection): ?>
			<tr>
				<td><?php echo $pageSection['PageSection']['id']; ?>&nbsp;</td>
				<td><?php echo $pageSection['PageSection']['title']; ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($pageSection['Page']['title'], array('controller' => 'pages', 'action' => 'admin_view', $pageSection['Page']['id'])); ?>
				</td>
				<td><?php echo $pageSection['PageSection']['created']; ?>&nbsp;</td>
				<td><?php echo $pageSection['PageSection']['modified']; ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link('View', array('action' => 'admin_view', $pageSection['PageSection']['id']), array('class' => 'btn')); ?>
					<?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $pageSection['PageSection']['id']), array('class' => 'btn')); ?>
					<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $pageSection['PageSection']['id']), array('class' => 'btn danger'), sprintf('Are you sure you want to delete # %s?', $pageSection['PageSection']['id'])); ?>
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
		<h3>Pages Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('List Pages', array('controller' => 'pages', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Page', array('controller' => 'pages', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
</aside>
