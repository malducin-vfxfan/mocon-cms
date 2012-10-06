<?php
/**
 * Page Sections admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       page_sections
 * @subpackage    page_sections.views
 */
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('Edit Page Section', array('action' => 'admin_edit', $pageSection['PageSection']['id']), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Form->postLink('Delete Page Section', array('action' => 'admin_delete', $pageSection['PageSection']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $pageSection['PageSection']['id'])); ?> </li>
			<li><?php echo $this->Html->link('List Page Sections', array('action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Page Section', array('action' => 'admin_add'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('List Pages', array('controller' => 'pages', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Page', array('controller' => 'pages', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
	<h2>Page Section</h2>
		<dl>
			<dt>Id</dt>
			<dd>
				<?php echo $pageSection['PageSection']['id']; ?>
				&nbsp;
			</dd>
			<dt>Title</dt>
			<dd>
				<?php echo $pageSection['PageSection']['title']; ?>
				&nbsp;
			</dd>
			<dt>Page</dt>
			<dd>
				<?php echo $this->Html->link($pageSection['Page']['title'], array('controller' => 'pages', 'action' => 'admin_view', $pageSection['Page']['id'])); ?>
				&nbsp;
			</dd>
			<dt>Section</dt>
			<dd>
				<?php echo $pageSection['PageSection']['section']; ?>
				&nbsp;
			</dd>
			<dt>Created</dt>
			<dd>
				<?php echo $pageSection['PageSection']['created']; ?>
				&nbsp;
			</dd>
			<dt>Modified</dt>
			<dd>
				<?php echo $pageSection['PageSection']['modified']; ?>
				&nbsp;
			</dd>
			<dt>Images Folder</dt>
			<dd>
				/img/pages/<?php echo sprintf("%010d", $pageSection['Page']['id']); ?>
				&nbsp;
			</dd>
		</dl>
	</section>
</div>
<div class="row">
	<section class="admin-main-content">
		<h2>Content</h2>
		<?php echo $pageSection['PageSection']['content']; ?>
	</section>
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
					<td><?php echo $this->Html->link($image, '/img/pages/'.sprintf("%010d", $pageSection['Page']['id']).'/'.$image, array('target' => '_blank')); ?></td>
					<td>
						<?php echo $this->Html->link('View', '/img/pages/'.sprintf("%010d", $pageSection['Page']['id']).'/'.$image, array('class' => 'btn', 'target' => '_blank')); ?>
						<?php echo $this->Form->postLink('Delete', array('controller' => 'pages', 'action' => 'admin_deleteFile', $pageSection['Page']['id'], $image), array('class' => 'btn btn-danger'), 'Are you sure you want to delete this image?'); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</aside>
</div>
<div class="row">
	<aside class="admin-related">
		<h3>Page Documents</h3>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Filename</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($documents as $document): ?>
				<tr>
					<td><?php echo $this->Html->link($document, '/files/pages/'.sprintf("%010d", $pageSection['Page']['id']).'/'.$document, array('target' => '_blank')); ?></td>
					<td>
						<?php echo $this->Html->link('View', '/files/pages/'.sprintf("%010d", $pageSection['Page']['id']).'/'.$document, array('class' => 'btn', 'target' => '_blank')); ?>
						<?php echo $this->Form->postLink('Delete', array('controller' => 'pages', 'action' => 'admin_deleteFile', $pageSection['Page']['id'], $document, 'files'), array('class' => 'btn btn-danger'), 'Are you sure you want to delete this document?'); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</aside>
</div>

