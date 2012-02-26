<?php
/**
 * Pages admin edit view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       pages
 * @subpackage    pages.views
 */
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $this->Form->value('Page.id')), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $this->Form->value('Page.id'))); ?></li>
			<li><?php echo $this->Html->link('List Pages', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
			<li><?php echo $this->Html->link('List Page Sections', array('controller' => 'page_sections', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Page Section', array('controller' => 'page_sections', 'action' => 'admin_add', $this->Form->value('Page.id')), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
		<h2>Edit a Page</h2>
		<?php echo $this->Form->create('Page', array('type' => 'file'));?>
			<fieldset>
				<legend>Admin Edit Page</legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('title');
					echo $this->Form->input('slug');
					echo $this->Form->input('published');
					echo $this->Form->input('main');
					echo $this->Form->input('File.image', array('type' => 'file'));
				?>
			</fieldset>
			<fieldset>
				<legend>Page Sections</legend>
				<?php
					foreach ($this->data['PageSection'] as $key => $value) {
						echo $this->Form->hidden('PageSection.'.$key.'.id');
						echo $this->Form->input('PageSection.'.$key.'.title');
						echo $this->Form->input('PageSection.'.$key.'.content', array('class' => 'span7'));
						echo $this->Form->input('PageSection.'.$key.'.section');
						echo $this->Form->hidden('PageSection.'.$key.'.page_id');
						echo "<hr />\n";
					}
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>
<div class="row">
	<aside class="admin-related">
		<h3>Related Page Sections</h3>
		<?php if (!empty($pageSections)): ?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Id</th>
					<th>Title</th>
					<th>Section</th>
					<th>Created</th>
					<th>Modified</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($pageSections as $pageSection): ?>
				<tr>
					<td><?php echo $pageSection['PageSection']['id'];?></td>
					<td><?php echo $pageSection['PageSection']['title'];?></td>
					<td><?php echo $pageSection['PageSection']['section'];?></td>
					<td><?php echo $pageSection['PageSection']['created'];?></td>
					<td><?php echo $pageSection['PageSection']['modified'];?></td>
					<td>
						<?php echo $this->Html->link('View', array('controller' => 'page_sections', 'action' => 'admin_view', $pageSection['PageSection']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Html->link('Edit', array('controller' => 'page_sections', 'action' => 'admin_edit', $pageSection['PageSection']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink('Delete', array('controller' => 'page_sections', 'action' => 'admin_delete', $pageSection['PageSection']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $pageSection['PageSection']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
	</aside>
</div>
<div class="row">
	<aside class="admin-related">
		<h3>Page Images</h3>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Filename</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($images as $image): ?>
				<tr>
					<td><?php echo $this->Html->link($image, '/img/pages/'.sprintf("%010d", $this->Form->value('Page.id')).'/'.$image, array('target' => '_blank')); ?></td>
					<td>
						<?php echo $this->Html->link('View', '/img/pages/'.sprintf("%010d", $this->Form->value('Page.id')).'/'.$image, array('class' => 'btn', 'target' => '_blank')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_deleteFile', $this->Form->value('Page.id'), $image), array('class' => 'btn btn-danger'), 'Are you sure you want to delete this image?'); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</aside>
</div>
