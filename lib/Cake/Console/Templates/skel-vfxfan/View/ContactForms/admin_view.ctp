<?php
/**
 * Contact Forms admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       contact_forms
 * @subpackage    contact_forms.views
 */
$this->extend('/Common/admin_view');

$this->assign('formTitle', 'Contact Form Messages');

$this->start('actions');
?>
			<li><?php echo $this->Form->postLink('Delete Contact Form Messages', array('action' => 'admin_delete', $contactForm['ContactForm']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $contactForm['ContactForm']['id'])); ?> </li>
			<li><?php echo $this->Html->link('List Contact Forms Messages', array('action' => 'admin_index'), array('class' => 'btn')); ?> </li>
<?php
$this->end();
?>
			<dt>Id</dt>
			<dd>
				<?php echo $contactForm['ContactForm']['id']; ?>
				&nbsp;
			</dd>
			<dt>Name</dt>
			<dd>
				<?php echo $contactForm['ContactForm']['name']; ?>
				&nbsp;
			</dd>
			<dt>Email</dt>
			<dd>
				<?php echo $this->Html->link($contactForm['ContactForm']['email'], 'mailto:'.$contactForm['ContactForm']['email']); ?>
				&nbsp;
			</dd>
			<dt>Message</dt>
			<dd>
				<?php echo $contactForm['ContactForm']['message']; ?>
				&nbsp;
			</dd>
			<dt>Created</dt>
			<dd>
				<?php echo $contactForm['ContactForm']['created']; ?>
				&nbsp;
			</dd>
			<dt>Modified</dt>
			<dd>
				<?php echo $contactForm['ContactForm']['modified']; ?>
				&nbsp;
			</dd>
