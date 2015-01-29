<?php
/**
 * Pages admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Pages
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Pages');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('New Page', array('action' => 'admin_add')); ?></li>
<?php
$this->end();

$this->start('relatedActions');
?>
			<li><?php echo $this->Html->link('List Page Sections', array('controller' => 'page_sections', 'action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New Page Section', array('controller' => 'page_sections', 'action' => 'admin_add')); ?> </li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('title'); ?></th>
					<th><?php echo $this->Paginator->sort('slug'); ?></th>
					<th><?php echo $this->Paginator->sort('published'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
<?php
$this->end();

$this->start('tableRows');
?>
				<?php foreach ($pages as $page): ?>
				<tr>
					<td><?php echo $page['Page']['id']; ?>&nbsp;</td>
					<td><?php echo $page['Page']['title']; ?>&nbsp;</td>
					<td><?php echo $page['Page']['slug']; ?>&nbsp;</td>
					<td><?php echo $page['Page']['published']; ?>&nbsp;</td>
					<td><?php echo $page['Page']['created']; ?>&nbsp;</td>
					<td><?php echo $page['Page']['modified']; ?>&nbsp;</td>
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								Action <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><?php echo $this->Html->link('View', array('action' => 'admin_view', $page['Page']['id'])); ?></li>
								<li><?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $page['Page']['id'])); ?></li>
								<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $page['Page']['id']), array('escape' => false, 'confirm' => sprintf('Are you sure you want to delete # %s?', $page['Page']['id']))); ?></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();
?>
