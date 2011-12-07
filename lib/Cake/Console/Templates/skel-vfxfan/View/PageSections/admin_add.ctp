<?php
/**
 * Page Sections admin add view.
 *
 * Page Sections admin add view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    page_sections
 */
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('List Page Sections', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
			<li><?php echo $this->Html->link('List Pages', array('controller' => 'pages', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Page', array('controller' => 'pages', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
		<h2>Add a Page Section</h2>
		<?php echo $this->Form->create('PageSection', array('class' => 'form-stacked'));?>
			<fieldset>
				<legend>Admin Add Page Section</legend>
				<?php
					echo $this->Form->input('title', array('div' => 'clearfix'));
					echo $this->Form->input('content', array('div' => 'clearfix', 'class' => 'span7'));
					echo $this->Form->input('page_id', array('div' => 'clearfix', 'selected' => $selected));
					echo $this->Form->input('section', array('div' => 'clearfix', 'default' => 0));
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>
