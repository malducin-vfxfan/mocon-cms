<?php
/**
 * Pages admin edit view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Pages
 */
$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Edit a Page');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Pages', array('action' => 'admin_index')); ?></li>
			<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $this->Form->value('Page.id')), array('escape' => false), sprintf('Are you sure you want to delete # %s?', $this->Form->value('Page.id'))); ?></li>
<?php
$this->end();

$this->start('relatedActions');
?>
			<li><?php echo $this->Html->link('List Page Sections', array('controller' => 'page_sections', 'action' => 'admin_index')); ?></li>
			<li><?php echo $this->Html->link('New Page Section', array('controller' => 'page_sections', 'action' => 'admin_add', $this->Form->value('Page.id'))); ?></li>
<?php
$this->end();
?>
		<?php
			echo $this->Form->create('Page', array(
				'type' => 'file',
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
				<legend>Admin Edit Page</legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('title');
					echo $this->Form->input('slug');
					echo $this->Form->input('published', array('div' => 'checkbox', 'class' => 'checkbox'));
					echo $this->Form->input('main', array('div' => 'checkbox', 'class' => 'checkbox'));
					echo $this->Form->input('File.image', array('type' => 'file'));
					echo $this->Form->input('File.document', array('type' => 'file'));
				?>
			</fieldset>
			<fieldset>
				<legend>Page Sections</legend>
				<?php
					foreach ($this->data['PageSection'] as $key => $value) {
						echo $this->Form->hidden('PageSection.'.$key.'.id');
						echo $this->Form->input('PageSection.'.$key.'.title');
						echo $this->Form->input('PageSection.'.$key.'.content');
						echo $this->Form->input('PageSection.'.$key.'.section', array('type' => 'number', 'min' => 0));
						echo $this->Form->hidden('PageSection.'.$key.'.page_id');
						echo "<hr />\n";
					}
				?>
			</fieldset>
		<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
<?php
$this->start('relatedContent');
?>
		<h3>Related Page Sections</h3>
		<?php if (!empty($pageSections)): ?>
		<table class="table table-striped table-bordered table-hover">
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
						<?php echo $this->Html->link('View', array('controller' => 'page_sections', 'action' => 'admin_view', $pageSection['PageSection']['id']), array('class' => 'btn btn-default')); ?>
						<?php echo $this->Html->link('Edit', array('controller' => 'page_sections', 'action' => 'admin_edit', $pageSection['PageSection']['id']), array('class' => 'btn btn-default')); ?>
						<?php echo $this->Form->postLink('Delete', array('controller' => 'page_sections', 'action' => 'admin_delete', $pageSection['PageSection']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $pageSection['PageSection']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>

		<h3>Page Images</h3>
		<table class="table table-striped table-bordered table-hover">
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
						<?php echo $this->Html->link('View', '/img/pages/'.sprintf("%010d", $this->Form->value('Page.id')).'/'.$image, array('class' => 'btn btn-default', 'target' => '_blank')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_deleteFile', $this->Form->value('Page.id'), 'file_name' => $image, 'base_location' => 'img', 'redirect_action' => 'admin_edit'), array('class' => 'btn btn-danger'), 'Are you sure you want to delete this image?'); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<h3>Page Documents</h3>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Filename</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($documents as $document): ?>
				<tr>
					<td><?php echo $this->Html->link($document, '/files/pages/'.sprintf("%010d", $this->Form->value('Page.id')).'/'.$document, array('target' => '_blank')); ?></td>
					<td>
						<?php echo $this->Html->link('View', '/files/pages/'.sprintf("%010d", $this->Form->value('Page.id')).'/'.$document, array('class' => 'btn btn-default', 'target' => '_blank')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_deleteFile', $this->Form->value('Page.id'), 'file_name' => $document, 'base_location' => 'files', 'redirect_action' => 'admin_edit'), array('class' => 'btn btn-danger'), 'Are you sure you want to delete this document?'); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
<?php
$this->end();
?>
