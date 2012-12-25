<?php
/**
 * Page Sections admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       page_sections
 * @subpackage    page_sections.views
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Page Sections');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('New Page Section', array('action' => 'admin_add'), array('class' => 'btn')); ?></li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id');?></th>
					<th><?php echo $this->Paginator->sort('title');?></th>
					<th><?php echo $this->Paginator->sort('page_id');?></th>
					<th><?php echo $this->Paginator->sort('created');?></th>
					<th><?php echo $this->Paginator->sort('modified');?></th>
<?php
$this->end();

$this->start('tableRows');
?>
				<?php foreach ($pageSections as $pageSection): ?>
				<tr>
					<td><?php echo $pageSection['PageSection']['id']; ?>&nbsp;</td>
					<td><?php echo $pageSection['PageSection']['title']; ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($pageSection['Page']['title'], array('controller' => 'pages', 'action' => 'admin_view', $pageSection['Page']['id'])); ?>
					</td>
					<td><?php echo $pageSection['PageSection']['created']; ?>&nbsp;</td>
					<td><?php echo $pageSection['PageSection']['modified']; ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link('View', array('action' => 'admin_view', $pageSection['PageSection']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $pageSection['PageSection']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $pageSection['PageSection']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $pageSection['PageSection']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();

$this->start('relatedActions1');
?>
			<li><?php echo $this->Html->link('List Pages', array('controller' => 'pages', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New Page', array('controller' => 'pages', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
<?php
$this->end();
?>
