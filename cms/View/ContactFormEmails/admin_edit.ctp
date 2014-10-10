<?php
/**
 * Contact Form Email admin view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.ContactFormEmails
 */
$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Edit a Contact Form Email');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Contact Form Emails', array('action' => 'admin_index')); ?></li>
			<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $this->request->data('ContactFormEmail.id')), array('escape' => false), sprintf('Are you sure you want to delete # %s?', $this->request->data('ContactFormEmail.id'))); ?></li>
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
				<legend>Admin Edit Contact Form Email</legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('email');
					echo $this->Form->input('name');
					echo $this->Form->input('active', array('div' => 'checkbox', 'class' => 'checkbox'));
				?>
			</fieldset>
		<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
