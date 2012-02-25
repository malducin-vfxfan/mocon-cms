<?php
/**
 * Contact Form Email admin view view.
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
			<li><?php echo $this->Html->link('Edit Contact Form Email', array('action' => 'admin_edit', $contactFormEmail['ContactFormEmail']['id']), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Form->postLink('Delete Contact Form Email', array('action' => 'admin_delete', $contactFormEmail['ContactFormEmail']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $contactFormEmail['ContactFormEmail']['id'])); ?> </li>
			<li><?php echo $this->Html->link('List Contact Form Email', array('action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Contact Form Email', array('action' => 'admin_add'), array('class' => 'btn')); ?> </li>
		</ul>
	</section>
	<section class="admin-content">
		<h2>Contact Form Email</h2>
		<dl>
			<dt>Id</dt>
			<dd>
				<?php echo $contactFormEmail['ContactFormEmail']['id']; ?>
				&nbsp;
			</dd>
			<dt>Email</dt>
			<dd>
				<?php echo $contactFormEmail['ContactFormEmail']['email']; ?>
				&nbsp;
			</dd>
			<dt>Name</dt>
			<dd>
				<?php echo $contactFormEmail['ContactFormEmail']['name']; ?>
				&nbsp;
			</dd>
			<dt>Active</dt>
			<dd>
				<?php echo $contactFormEmail['ContactFormEmail']['active']; ?>
				&nbsp;
			</dd>
			<dt>Created</dt>
			<dd>
				<?php echo $contactFormEmail['ContactFormEmail']['created']; ?>
				&nbsp;
			</dd>
			<dt>Modified</dt>
			<dd>
				<?php echo $contactFormEmail['ContactFormEmail']['modified']; ?>
				&nbsp;
			</dd>
		</dl>
	</section>
</div>