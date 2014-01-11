<?php
/**
 * Posts admin edit view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Posts.View
 */
if (Configure::read('TinyMCE.active')) {
	echo $this->element('TinyMCE/config_basic');
}

$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Edit a Post');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Posts', array('action' => 'admin_index')); ?></li>
			<li><?php echo $this->Form->postLink($this->Html->tag('span', 'Delete', array('class' => 'text-danger')), array('action' => 'admin_delete', $this->Form->value('Post.id')), array('escape' => false), sprintf('Are you sure you want to delete # %s?', $this->Form->value('Post.id'))); ?></li>
<?php
$this->end();

$this->start('relatedActions');
?>
			<li><?php echo $this->Html->link('List Users', array('controller' => 'users', 'action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add')); ?> </li>
<?php
$this->end();
?>
		<?php
			echo $this->Form->create('Post', array(
				'type' => 'file',
				'inputDefaults' => array(
					'div' => array('class' => 'form-group'),
					'class' => 'form-control',
					'error' => array(
						'attributes' => array('class' => 'text-danger')
					)
				)
			));
		?>
			<fieldset>
				<legend>Admin Edit Post</legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('title');
					echo $this->Form->input('summary');
					echo $this->Form->input('content');
					echo $this->Form->input('slug');
					echo $this->Form->input('File.image', array('type' => 'file'));
					echo $this->Form->hidden('user_id');
				?>
			</fieldset>
			<fieldset>
				<legend>Current Image</legend>
				<?php echo $this->FormatImage->idImage('posts/'.$this->Form->value('year'), $this->Form->value('id'), array(), 'posts'); ?>
			</fieldset>
		<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
