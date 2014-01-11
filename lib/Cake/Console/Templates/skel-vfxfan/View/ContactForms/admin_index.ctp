<?php
/**
 * Contact Forms admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.ContactForms.View
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Contact Form Messages');

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('email'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
<?php
$this->end();

$this->start('tableRows');
?>
				<?php foreach ($contactForms as $contactForm): ?>
				<tr>
					<td><?php echo $contactForm['ContactForm']['id']; ?>&nbsp;</td>
					<td><?php echo $contactForm['ContactForm']['name']; ?>&nbsp;</td>
					<td><?php echo $contactForm['ContactForm']['email']; ?>&nbsp;</td>
					<td><?php echo $contactForm['ContactForm']['created']; ?>&nbsp;</td>
					<td><?php echo $contactForm['ContactForm']['modified']; ?>&nbsp;</td>
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								Action <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><?php echo $this->Html->link('View', array('action' => 'admin_view', $contactForm['ContactForm']['id'])); ?></li>
								<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $contactForm['ContactForm']['id']), array('escape' => false), sprintf('Are you sure you want to delete # %s?', $contactForm['ContactForm']['id'])); ?></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();
?>
