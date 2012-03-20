<?php
/**
 * Contact Form Email admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @subpackage    contact_form_emails
 * @subpackage    contact_form_emails.views
 */
?>
<div class="row">
	<section class="admin-main-content">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo $this->Html->link('New Contact Form Email', array('action' => 'admin_add'), array('class' => 'btn')); ?></li>
		</ul>
	</section>
	<section class="admin-main-content">
		<h2>Contact Form Email</h2>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id');?></th>
					<th><?php echo $this->Paginator->sort('email');?></th>
					<th><?php echo $this->Paginator->sort('active');?></th>
					<th><?php echo $this->Paginator->sort('created');?></th>
					<th><?php echo $this->Paginator->sort('modified');?></th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
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
			</tbody>
		</table>
		<p>
		<?php
			echo $this->Paginator->counter(array(
				'format' => 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'
			));
		?>
		</p>

		<div class="paging">
		<?php
			echo $this->Paginator->prev('« previous', array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => '', 'first' => 'first', 'last' => 'last'));
			echo $this->Paginator->next('next »', array(), null, array('class' => 'next disabled'));
		?>
		</div>
	</section>
</div>
