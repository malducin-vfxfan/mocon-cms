<?php
/**
 * Page Sections admin add view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       page_sections
 * @subpackage    page_sections.views
 */
if (Configure::read('TinyMCE.active')) {
	echo $this->element('TinyMCE/config_basic', array('external_image_list_url' => $this->Html->url(array('controller' => 'page_sections', 'action' => 'admin_tinymceImageList', $this->Form->value('Page.id')))));
}
$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Add a Page Section');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Page Sections', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
			<li><?php echo $this->Html->link('List Pages', array('controller' => 'pages', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Page', array('controller' => 'pages', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
<?php
$this->end();
?>
		<?php echo $this->Form->create('PageSection');?>
			<fieldset>
				<legend>Admin Add Page Section</legend>
				<?php
					echo $this->Form->input('title');
					echo $this->Form->input('content', array('class' => 'span7'));
					echo $this->Form->input('page_id', array('value' => $selected));
					echo $this->Form->input('section', array('default' => 0, 'type' => 'number', 'min' => 0));
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
