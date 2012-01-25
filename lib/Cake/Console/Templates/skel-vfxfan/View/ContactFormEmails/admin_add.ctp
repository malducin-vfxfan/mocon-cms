<?php
/**
 * Contact Form Email admin view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @subpackage    contact_form_emails
 * @subpackage    contact_form_emails.views
 */
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('List Contact Form Email', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
		</ul>
	</section>
	<section class="admin-content">
		<h2>Admin Add a Contact Form Email</h2>
		<?php echo $this->Form->create('ContactFormEmail', array('class' => 'form-stacked'));?>
			<fieldset>
				<legend>Admin Add Contact Form Email</legend>
				<?php
					echo $this->Form->input('email', array('div' => 'clearfix'));
					echo $this->Form->input('name', array('div' => 'clearfix'));
					echo $this->Form->input('active', array('div' => 'clearfix'));
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>
