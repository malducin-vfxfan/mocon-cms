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
			<li><?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $this->Form->value('Page.id')), array('class' => 'btn danger'), sprintf('Are you sure you want to delete # %s?', $this->Form->value('Page.id'))); ?></li>
			<li><?php echo $this->Html->link('List Pages', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
			<li><?php echo $this->Html->link('List Page Sections', array('controller' => 'page_sections', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Page Section', array('controller' => 'page_sections', 'action' => 'admin_add', $this->Form->value('Page.id')), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
		<h2>Edit a Page</h2>
		<?php echo $this->Form->create('Page', array('class' => 'form-stacked', 'type' => 'file'));?>
			<fieldset>
				<legend>Admin Edit Page</legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('title', array('div' => 'clearfix'));
					echo $this->Form->input('slug', array('div' => 'clearfix'));
					echo $this->Form->input('main', array('div' => 'clearfix'));
					echo $this->Form->input('File.image', array('div' => 'clearfix', 'type' => 'file'));
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
		<h3>Images</h3>
		<table class="bordered-table zebra-striped">
		<?php foreach ($images as $image): ?>
			<tr>
				<td><?php echo $this->Html->link($image, '/img/pages/'.sprintf("%010d", $this->Form->value('Page.id')).'/'.$image, array('target' => '_blank')); ?></td>
				<td><?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete_file', $this->Form->value('Page.id'), $image), array('class' => 'btn danger'), 'Are you sure you want to delete this image?'); ?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	</section>
</div>
