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
if (Configure::read('TinyMCE.active')) {
	echo $this->element('TinyMCE/config_basic', array('external_image_list_url' => $this->Html->url(array('controller' => 'page_sections', 'action' => 'admin_tinymceImageList', $this->Form->value('Page.id')))));
}

$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Add a Page');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('Add Page Section to Form', '#', array('id' => 'addPageSection', 'class' => 'btn'));?></li>
			<li><?php echo $this->Html->link('List Pages', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
			<li><?php echo $this->Html->link('List Page Sections', array('controller' => 'page_sections', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Page Section', array('controller' => 'page_sections', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
<?php
$this->end();
?>
		<?php echo $this->Form->create('Page');?>
			<fieldset>
				<legend>Admin Add Page</legend>
				<?php
					echo $this->Form->input('Page.title', array('label'=>'Page Title'));
					echo $this->Form->input('Page.published');
					echo $this->Form->input('Page.main');
					echo $this->Form->input('PageSection.0.title', array('label'=>'Section Title', 'class' => 'page-section-title'));
					echo $this->Form->input('PageSection.0.section', array('class' => 'page-section-section', 'default' => 0, 'type' => 'number', 'min' => 0));
					echo $this->Form->input('PageSection.0.content', array('class' => 'page-section-content span7'));
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
