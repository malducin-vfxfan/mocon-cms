<?php
/**
 * Pages admin view view.
 *
 * Pages admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    pages
 */
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('Edit Page', array('action' => 'admin_edit', $page['Page']['id']), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Form->postLink('Delete Page', array('action' => 'admin_delete', $page['Page']['id']), array('class' => 'btn danger'), sprintf('Are you sure you want to delete # %s?', $page['Page']['id'])); ?> </li>
			<li><?php echo $this->Html->link('List Pages', array('action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Page', array('action' => 'admin_add'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('List Page Sections', array('controller' => 'page_sections', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Page Section', array('controller' => 'page_sections', 'action' => 'admin_add', $page['Page']['id']), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
	<h2>Page</h2>
		<dl>
			<dt>Id</dt>
			<dd>
				<?php echo $page['Page']['id']; ?>
				&nbsp;
			</dd>
			<dt>Title</dt>
			<dd>
				<?php echo $page['Page']['title']; ?>
				&nbsp;
			</dd>
			<dt>Slug</dt>
			<dd>
				<?php echo $page['Page']['slug']; ?>
				&nbsp;
			</dd>
			<dt>Main</dt>
			<dd>
				<?php echo $page['Page']['main']; ?>
				&nbsp;
			</dd>
			<dt>Created</dt>
			<dd>
				<?php echo $page['Page']['created']; ?>
				&nbsp;
			</dd>
			<dt>Modified</dt>
			<dd>
				<?php echo $page['Page']['modified']; ?>
				&nbsp;
			</dd>
			<dt>Images Folder</dt>
			<dd>
				/img/pages/<?php echo sprintf("%010d", $page['Page']['id']); ?>
				&nbsp;
			</dd>
		</dl>
	</section>
</div>
<div class="row">
	<aside class="admin-related">
		<h3>Related Page Sections</h3>
		<?php if (!empty($page['PageSection'])): ?>
		<table class="bordered-table zebra-striped">
			<tr>
				<th>Id</th>
				<th>Title</th>
				<th>Section</th>
				<th>Created</th>
				<th>Modified</th>
				<th>Actions</th>
			</tr>
			<?php foreach ($page['PageSection'] as $pageSection): ?>
			<tr>
				<td><?php echo $pageSection['id'];?></td>
				<td><?php echo $pageSection['title'];?></td>
				<td><?php echo $pageSection['section'];?></td>
				<td><?php echo $pageSection['created'];?></td>
				<td><?php echo $pageSection['modified'];?></td>
				<td>
					<?php echo $this->Html->link('View', array('controller' => 'page_sections', 'action' => 'admin_view', $pageSection['id']), array('class' => 'btn')); ?>
					<?php echo $this->Html->link('Edit', array('controller' => 'page_sections', 'action' => 'admin_edit', $pageSection['id']), array('class' => 'btn')); ?>
					<?php echo $this->Form->postLink('Delete', array('controller' => 'page_sections', 'action' => 'admin_delete', $pageSection['id']), array('class' => 'btn danger'), sprintf('Are you sure you want to delete # %s?', $pageSection['id'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php endif; ?>

		<section class="admin-view-related-actions">
			<h4>Related Actions</h4>
			<ul class="action-buttons-list">
				<li><?php echo $this->Html->link('New Page Section', array('controller' => 'page_sections', 'action' => 'admin_add', $page['Page']['id']), array('class' => 'btn'));?> </li>
			</ul>
		</section>
	</aside>
</div>
<div class="row">
	<aside class="admin-related">
		<h3>Page Images</h3>
		<table class="bordered-table zebra-striped">
			<tr>
				<th>Filename</th>
				<th>Actions</th>
			</tr>
			<?php foreach ($images as $image): ?>
			<tr>
				<td><?php echo $this->Html->link($image, '/img/pages/'.sprintf("%010d", $page['Page']['id']).'/'.$image, array('target' => '_blank')); ?></td>
				<td>
					<?php echo $this->Html->link('View', '/img/pages/'.sprintf("%010d", $page['Page']['id']).'/'.$image, array('class' => 'btn', 'target' => '_blank')); ?>
					<?php echo $this->Form->postLink('Delete', array('action' => 'admin_deleteFile', $page['Page']['id'], $image), array('class' => 'btn danger'), 'Are you sure you want to delete this image?'); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	</aside>
</div>
