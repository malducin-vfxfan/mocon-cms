<?php
/**
 * Albums admin upload image view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Albums.View
 */
$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Add Album Image');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Albums', array('action' => 'admin_index')); ?></li>
<?php
$this->end();
?>
		<?php
			echo $this->Form->create('Album', array(
				'type' => 'file',
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
				<legend><?php echo 'Admin Add Album'; ?></legend>
				<?php
					echo $this->Form->input('File.image', array('type' => 'file'));
				?>
			</fieldset>
		<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
