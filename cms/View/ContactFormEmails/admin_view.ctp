<?php
/**
 * Contact Form Email admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.ContactFormEmails
 */
$this->extend('/Common/admin_view');

$this->assign('formTitle', 'Contact Form Email');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('Edit Contact Form Email', array('action' => 'admin_edit', $contactFormEmail['ContactFormEmail']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete Contact Form Email', array('class' => 'text-danger')), array('action' => 'admin_delete', $contactFormEmail['ContactFormEmail']['id']), array('escape' => false, 'confirm' => sprintf('Are you sure you want to delete # %s?', $contactFormEmail['ContactFormEmail']['id']))); ?> </li>
			<li><?php echo $this->Html->link('List Contact Form Emails', array('action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New Contact Form Email', array('action' => 'admin_add')); ?> </li>
<?php
$this->end();
?>
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
