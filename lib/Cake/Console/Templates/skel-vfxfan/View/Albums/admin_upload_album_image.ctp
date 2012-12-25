<?php
/**
 * Albums admin upload image view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       albums
 * @subpackage    albums.views
 */
$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Add Album Image');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Albums', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
<?php
$this->end();
?>
		<?php echo $this->Form->create('Album', array('type' => 'file'));?>
			<fieldset>
				<legend><?php echo 'Admin Add Album'; ?></legend>
				<?php
					echo $this->Form->input('File.image', array('type' => 'file'));
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
