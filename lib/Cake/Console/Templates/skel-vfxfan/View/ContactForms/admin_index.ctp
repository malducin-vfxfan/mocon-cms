<?php
/**
 * Contact Forms admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @subpackage    contact_forms
 * @subpackage    contact_forms.views
 */
?>
<div class="row">
	<section class="admin-main-content">
		<h2>Contact Forms</h2>
		<table class="bordered-table zebra-striped">
			<tr>
				<th><?php echo $this->Paginator->sort('id');?></th>
				<th><?php echo $this->Paginator->sort('name');?></th>
				<th><?php echo $this->Paginator->sort('email');?></th>
				<th><?php echo $this->Paginator->sort('created');?></th>
				<th><?php echo $this->Paginator->sort('modified');?></th>
				<th>Actions</th>
			</tr>
			<?php foreach ($contactForms as $contactForm): ?>
			<tr>
				<td><?php echo $contactForm['ContactForm']['id']; ?>&nbsp;</td>
				<td><?php echo $contactForm['ContactForm']['name']; ?>&nbsp;</td>
				<td><?php echo $contactForm['ContactForm']['email']; ?>&nbsp;</td>
				<td><?php echo $contactForm['ContactForm']['created']; ?>&nbsp;</td>
				<td><?php echo $contactForm['ContactForm']['modified']; ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link('View', array('action' => 'admin_view', $contactForm['ContactForm']['id']), array('class' => 'btn')); ?>
					<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $contactForm['ContactForm']['id']), array('class' => 'btn'), sprintf('Are you sure you want to delete # %s?', $contactForm['ContactForm']['id'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
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
			echo $this->Paginator->first('first');
			echo $this->Paginator->prev('« previous', array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next('next »', array(), null, array('class' => 'next disabled'));
			echo $this->Paginator->first('last');
		?>
		</div>
	</section>
</div>
