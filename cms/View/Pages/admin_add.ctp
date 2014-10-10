<?php
/**
 * Pages admin add view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Pages
 */
if (Configure::read('TinyMCE.active')) {
	echo $this->element('TinyMCE/config_basic', array('external_image_list_url' => $this->Html->url(array('controller' => 'page_sections', 'action' => 'admin_tinymceImageList', $this->request->data('Page.id')))));
}

$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Add a Page');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('Add Page Section to Form', '#', array('id' => 'addPageSection')); ?></li>
			<li><?php echo $this->Html->link('List Pages', array('action' => 'admin_index')); ?></li>
<?php
$this->end();

$this->start('relatedActions');
?>
			<li><?php echo $this->Html->link('List Page Sections', array('controller' => 'page_sections', 'action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New Page Section', array('controller' => 'page_sections', 'action' => 'admin_add')); ?> </li>
<?php
$this->end();
?>
		<?php
			echo $this->Form->create('Page', array(
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
				<legend>Admin Add Page</legend>
				<?php
					echo $this->Form->input('Page.title', array('label' => 'Page Title'));
					echo $this->Form->input('Page.published', array('div' => 'checkbox', 'class' => 'checkbox'));
					echo $this->Form->input('Page.main', array('div' => 'checkbox', 'class' => 'checkbox'));
					echo $this->Form->input('PageSection.0.title', array('label' => 'Section Title'));
					echo $this->Form->input('PageSection.0.section', array('default' => 0, 'type' => 'number', 'min' => 0));
					echo $this->Form->input('PageSection.0.content');
				?>
			</fieldset>
			<fieldset id="extraPageSections">
				<legend>Extra Page Sections</legend>
			</fieldset>
		<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
