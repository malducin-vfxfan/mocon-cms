<?php
/**
 * Contact Form Email admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       contact_form_emails
 * @subpackage    contact_form_emails.views
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Contact Form Emails');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('New Contact Form Email', array('action' => 'admin_add'), array('class' => 'btn')); ?></li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id');?></th>
					<th><?php echo $this->Paginator->sort('email');?></th>
					<th><?php echo $this->Paginator->sort('active');?></th>
					<th><?php echo $this->Paginator->sort('created');?></th>
					<th><?php echo $this->Paginator->sort('modified');?></th>
<?php
$this->end();

$this->start('tableRows');
?>
				<?php foreach ($contactFormEmails as $contactFormEmail): ?>
				<tr>
					<td><?php echo $contactFormEmail['ContactFormEmail']['id']; ?>&nbsp;</td>
					<td><?php echo $contactFormEmail['ContactFormEmail']['email']; ?>&nbsp;</td>
					<td><?php echo $contactFormEmail['ContactFormEmail']['active']; ?>&nbsp;</td>
					<td><?php echo $contactFormEmail['ContactFormEmail']['created']; ?>&nbsp;</td>
					<td><?php echo $contactFormEmail['ContactFormEmail']['modified']; ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link('View', array('action' => 'admin_view', $contactFormEmail['ContactFormEmail']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $contactFormEmail['ContactFormEmail']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $contactFormEmail['ContactFormEmail']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $contactFormEmail['ContactFormEmail']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();
?>
