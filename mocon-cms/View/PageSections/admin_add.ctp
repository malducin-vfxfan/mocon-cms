<?php
/**
 * Page Sections admin add view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.PageSections
 */
if (Configure::read('TinyMCE.active')) {
	echo $this->element('TinyMCE/config_basic', array('external_image_list_url' => $this->Html->url(array('controller' => 'page_sections', 'action' => 'admin_tinymceImageList', $this->request->data('Page.id')))));
}

$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Add a Page Section');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Page Sections', array('action' => 'admin_index')); ?></li>
<?php
$this->end();

$this->start('relatedActions');
?>
			<li><?php echo $this->Html->link('List Pages', array('controller' => 'pages', 'action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New Page', array('controller' => 'pages', 'action' => 'admin_add')); ?> </li>
<?php
$this->end();
?>
		<?php
			echo $this->Form->create('PageSection', array(
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
				<legend>Admin Add Page Section</legend>
				<?php
					echo $this->Form->input('title');
					echo $this->Form->input('content');
					echo $this->Form->input('page_id', array('value' => $selected));
					echo $this->Form->input('section', array('default' => 0, 'type' => 'number', 'min' => 0));
				?>
			</fieldset>
		<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
