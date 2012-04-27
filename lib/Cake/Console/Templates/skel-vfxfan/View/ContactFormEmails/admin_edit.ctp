<?php
/**
 * Contact Form Email admin view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       contact_form_emails
 * @subpackage    contact_form_emails.views
 */
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $this->Form->value('ContactFormEmail.id')), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $this->Form->value('ContactFormEmail.id'))); ?></li>
			<li><?php echo $this->Html->link('List Contact Form Email', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
		</ul>
	</section>
	<section class="admin-content">
		<h2>Admin Edit a Contact Form Email</h2>
		<?php echo $this->Form->create('ContactFormEmail');?>
			<fieldset>
				<legend>Admin Edit Contact Form Email</legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('email');
					echo $this->Form->input('name');
					echo $this->Form->input('active');
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>
