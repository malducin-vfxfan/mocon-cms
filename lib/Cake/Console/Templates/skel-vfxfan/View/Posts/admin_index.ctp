<?php
/**
 * Posts admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       posts
 * @subpackage    posts.views
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Posts');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('New Post', array('action' => 'admin_add'), array('class' => 'btn')); ?></li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id');?></th>
					<th><?php echo $this->Paginator->sort('title');?></th>
					<th><?php echo $this->Paginator->sort('user_id');?></th>
					<th><?php echo $this->Paginator->sort('created');?></th>
					<th><?php echo $this->Paginator->sort('modified');?></th>
<?php
$this->end();

$this->start('tableRows');
?>
				<?php foreach ($posts as $post): ?>
				<tr>
					<td><?php echo $post['Post']['id']; ?>&nbsp;</td>
					<td><?php echo $post['Post']['title']; ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($post['User']['username'], array('controller' => 'users', 'action' => 'admin_view', $post['User']['id'])); ?>
					</td>
					<td><?php echo $post['Post']['created']; ?>&nbsp;</td>
					<td><?php echo $post['Post']['modified']; ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link('View', array('action' => 'admin_view', $post['Post']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $post['Post']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $post['Post']['id']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $post['Post']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();

$this->start('relatedActions1');
?>
			<li><?php echo $this->Html->link('List Users', array('controller' => 'users', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
<?php
$this->end();
?>
