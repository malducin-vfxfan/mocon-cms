<?php
/**
 * Albums admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       albums
 * @subpackage    albums.views
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Albums');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('New Album', array('action' => 'admin_add'), array('class' => 'btn')); ?></li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id');?></th>
					<th><?php echo $this->Paginator->sort('name');?></th>
					<th><?php echo $this->Paginator->sort('created');?></th>
					<th><?php echo $this->Paginator->sort('modified');?></th>
<?php
$this->end();

$this->start('tableRows');
?>
				<?php foreach ($albums as $album): ?>
				<tr>
					<td><?php echo $album['Album']['id']; ?>&nbsp;</td>
					<td><?php echo $album['Album']['name']; ?>&nbsp;</td>
					<td><?php echo $album['Album']['created']; ?>&nbsp;</td>
					<td><?php echo $album['Album']['modified']; ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link('View', array('action' => 'admin_view', $album['Album']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $album['Album']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $album['Album']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $album['Album']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();
?>
