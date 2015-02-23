<?php
/**
 * Contact Form Email admin view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.ContactFormEmails
 */
$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Add a Contact Form Email');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Contact Form Emails', array('action' => 'admin_index')); ?></li>
<?php
$this->end();
?>
		<?php
			echo $this->Form->create('ContactFormEmail', array(
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
				<legend>Admin Add Contact Form Email</legend>
				<?php
					echo $this->Form->input('email');
					echo $this->Form->input('name');
					echo $this->Form->input('active', array('div' => 'checkbox', 'class' => 'checkbox', 'label' => false, 'before' => '<label>', 'after' => 'Active</label>'));
				?>
			</fieldset>
		<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
