<?php
/**
 * Posts admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Posts
 */
$this->extend('/Common/admin_view');

$this->assign('formTitle', 'Post');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('Edit Post', array('action' => 'admin_edit', $post['Post']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete Post', array('class' => 'text-danger')), array('action' => 'admin_delete', $post['Post']['id']), array('escape' => false), sprintf('Are you sure you want to delete # %s?', $post['Post']['id'])); ?> </li>
			<li><?php echo $this->Html->link('List Posts', array('action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New Post', array('action' => 'admin_add')); ?> </li>
<?php
$this->end();

$this->start('relatedActions');
?>
			<li><?php echo $this->Html->link('List Users', array('controller' => 'users', 'action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add')); ?> </li>
<?php
$this->end();
?>
			<dt>Id</dt>
			<dd>
				<?php echo $post['Post']['id']; ?>
				&nbsp;
			</dd>
			<dt>Title</dt>
			<dd>
				<?php echo $post['Post']['title']; ?>
				&nbsp;
			</dd>
			<dt>Summary</dt>
			<dd>
				<?php echo $post['Post']['summary']; ?>
				&nbsp;
			</dd>
			<dt>Content</dt>
			<dd>
				<?php echo $post['Post']['content']; ?>
				&nbsp;
			</dd>
			<dt>Slug</dt>
			<dd>
				<?php echo $post['Post']['slug']; ?>
				&nbsp;
			</dd>
			<dt>User</dt>
			<dd>
				<?php echo $this->Html->link($post['User']['username'], array('controller' => 'users', 'action' => 'admin_view', $post['User']['id'])); ?>
				&nbsp;
			</dd>
			<dt>Created</dt>
			<dd>
				<?php echo $post['Post']['created']; ?>
				&nbsp;
			</dd>
			<dt>Modified</dt>
			<dd>
				<?php echo $post['Post']['modified']; ?>
				&nbsp;
			</dd>
			<dt>Image</dt>
			<dd>
				<?php echo $this->FormatImage->idImage('posts/'.$post['Post']['year'], $post['Post']['id'], array(), 'posts'); ?>
				&nbsp;
			</dd>