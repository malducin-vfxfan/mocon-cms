<?php
/**
 * Posts admin add view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       posts
 * @subpackage    posts.views
 */
if (Configure::read('TinyMCE.active')) {
	echo $this->element('TinyMCE/config_basic', array('external_image_list_url' => $this->Html->url(array('controller' => 'page_sections', 'action' => 'admin_tinymceImageList', $this->Form->value('Page.id')))));
}
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('List Posts', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
			<li><?php echo $this->Html->link('List Users', array('controller' => 'users', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
		<h2>Add a Post</h2>
		<?php echo $this->Form->create('Post', array('class' => 'form-stacked', 'type' => 'file'));?>
			<fieldset>
				<legend>Admin Add Post</legend>
				<?php
					echo $this->Form->input('title', array('div' => 'clearfix'));
					echo $this->Form->input('summary', array('div' => 'clearfix'));
					echo $this->Form->input('content', array('div' => 'clearfix', 'class' => 'span7'));
					echo $this->Form->input('File.image', array('div' => 'clearfix', 'type' => 'file'));
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>
