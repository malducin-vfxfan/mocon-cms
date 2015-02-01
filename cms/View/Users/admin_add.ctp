<?php
/**
 * Users admin add view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Users
 */
$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Add a User');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Users', array('action' => 'admin_index')); ?></li>
<?php
$this->end();

$this->start('relatedActions');
?>
			<li><?php echo $this->Html->link('List Groups', array('controller' => 'groups', 'action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New Group', array('controller' => 'groups', 'action' => 'admin_add')); ?> </li>
			<li><?php echo $this->Html->link('List Posts', array('controller' => 'posts', 'action' => 'admin_index')); ?> </li>
			<li><?php echo $this->Html->link('New Post', array('controller' => 'posts', 'action' => 'admin_add')); ?> </li>
<?php
$this->end();
?>
		<?php
			echo $this->Form->create('User', array(
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
				<legend>Admin Add User</legend>
				<?php
					echo $this->Form->input('username');
					echo $this->Form->input('password');
					echo $this->Form->input('group_id');
				?>
			</fieldset>
		<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
