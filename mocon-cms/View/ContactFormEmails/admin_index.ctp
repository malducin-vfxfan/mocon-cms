<?php
/**
 * Contact Form Email admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.ContactFormEmails
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Contact Form Emails');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('New Contact Form Email', array('action' => 'admin_add')); ?></li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('email'); ?></th>
					<th><?php echo $this->Paginator->sort('active'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
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
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								Action <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><?php echo $this->Html->link('View', array('action' => 'admin_view', $contactFormEmail['ContactFormEmail']['id'])); ?></li>
								<li><?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $contactFormEmail['ContactFormEmail']['id'])); ?></li>
								<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $contactFormEmail['ContactFormEmail']['id']), array('escape' => false, 'confirm' => sprintf('Are you sure you want to delete # %s?', $contactFormEmail['ContactFormEmail']['id']))); ?></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();
?>
