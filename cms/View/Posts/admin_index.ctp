<?php
/**
 * Posts admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Posts
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'Posts');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('New Post', array('action' => 'admin_add')); ?></li>
<?php
$this->end();

$this->start('relatedActions');
?>
			<li><?php echo $this->Html->link('List Users', array('controller' => 'users', 'action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add')); ?> </li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('title'); ?></th>
					<th><?php echo $this->Paginator->sort('user_id'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
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
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								Action <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><?php echo $this->Html->link('View', array('action' => 'admin_view', $post['Post']['id'])); ?></li>
								<li><?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $post['Post']['id'])); ?></li>
								<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $post['Post']['id']), array('escape' => false, 'confirm' => sprintf('Are you sure you want to delete # %s?', $post['Post']['id']))); ?></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();
?>
