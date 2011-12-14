<?php
/**
 * Pages admin add view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       pages
 * @subpackage    pages.views
 */
$this->Html->script(array('forms_pages'), array('inline' => false));
if (Configure::read('TinyMCE.active')) {
	echo $this->element('TinyMCE/config_basic', array('external_image_list_url' => $this->Html->url(array('controller' => 'page_sections', 'action' => 'admin_tinymceImageList', $this->Form->value('Page.id')))));
}
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('Add Page Section to Form', '#', array('id' => 'addPageSection', 'class' => 'btn'));?></li>
			<li><?php echo $this->Html->link('List Pages', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
			<li><?php echo $this->Html->link('List Page Sections', array('controller' => 'page_sections', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Page Section', array('controller' => 'page_sections', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
		<h2>Add a page</h2>
		<?php echo $this->Form->create('Page', array('class' => 'form-stacked'));?>
			<fieldset>
				<legend>Admin Add Page</legend>
				<?php
					echo $this->Form->input('Page.title', array('div' => 'clearfix', 'label'=>'Page Title'));
					echo $this->Form->input('Page.main', array('div' => 'clearfix'));
					echo $this->Form->input('PageSection.0.title', array('div' => 'clearfix', 'label'=>'Section Title', 'class' => 'page_section_title'));
					echo $this->Form->input('PageSection.0.section', array('div' => 'clearfix', 'class' => 'page_section_section'));
					echo $this->Form->input('PageSection.0.content', array('div' => 'clearfix', 'class' => 'page_section_content span7'));
				?>
			</fieldset>
			<fieldset id="extraPageSections">
				<legend>Extra Page Sections</legend>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>
