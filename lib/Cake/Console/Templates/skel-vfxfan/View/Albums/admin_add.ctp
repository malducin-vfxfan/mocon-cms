<?php
/**
 * Albums admin view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @subpackage    albums
 * @subpackage    albums.views
 */
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('List Albums', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
		</ul>
	</section>
	<section class="admin-content">
		<h2><?php echo 'Admin Add a Album'; ?></h2>
		<?php echo $this->Form->create('Album', array('class' => 'form-stacked', 'type' => 'file'));?>
			<fieldset>
				<legend><?php echo 'Admin Add Album'; ?></legend>
				<?php
					echo $this->Form->input('name', array('div' => 'clearfix'));
					echo $this->Form->input('description', array('div' => 'clearfix'));
					echo $this->Form->input('File.image', array('div' => 'clearfix', 'type' => 'file'));
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>
