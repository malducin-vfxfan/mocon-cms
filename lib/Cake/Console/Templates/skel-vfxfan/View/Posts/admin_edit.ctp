<?php
/**
 * Posts admin edit view.
 *
 * Posts admin edit view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    posts
 */
if (Configure::read('TinyMCE.active')) {
	echo $this->element('TinyMCE/config_basic', array('external_image_list_url' => $this->Html->url(array('controller' => 'page_sections', 'action' => 'admin_tinymceImageList', $this->Form->value('Page.id')))));
}
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $this->Form->value('Post.id')), array('class' => 'btn danger'), sprintf('Are you sure you want to delete # %s?', $this->Form->value('Post.id'))); ?></li>
			<li><?php echo $this->Html->link('List Posts', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
			<li><?php echo $this->Html->link('List Users', array('controller' => 'users', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
		<h2>Edit a Post</h2>
		<?php echo $this->Form->create('Post', array('class' => 'form-stacked', 'type' => 'file'));?>
			<fieldset>
				<legend>Admin Edit Post</legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('title', array('div' => 'clearfix'));
					echo $this->Form->input('summary', array('div' => 'clearfix'));
					echo $this->Form->input('content', array('div' => 'clearfix', 'class' => 'span7'));
					echo $this->Form->input('slug', array('div' => 'clearfix'));
					echo $this->Form->input('File.image', array('div' => 'clearfix', 'type' => 'file'));
					echo $this->Form->hidden('user_id');
				?>
			</fieldset>
			<fieldset>
				<legend>Current Image</legend>
				<?php echo $this->FormatImage->idImage('posts', $this->Form->value('id')); ?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>
