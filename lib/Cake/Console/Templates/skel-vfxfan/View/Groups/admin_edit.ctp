<?php
/**
 * Groups admin edit view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       groups
 * @subpackage    groups.views
 */
$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Edit a Group');

$this->start('actions');
?>
			<li><?php echo $this->Form->postLink('Delete', array('action' => 'admin_delete', $this->Form->value('Group.id')), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', $this->Form->value('Group.id'))); ?></li>
			<li><?php echo $this->Html->link('List Groups', array('action' => 'admin_index'), array('class' => 'btn'));?></li>
			<li><?php echo $this->Html->link('List Users', array('controller' => 'users', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>
			<li><?php echo $this->Html->link('New User', array('controller' => 'users', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>
<?php
$this->end();
?>
		<?php echo $this->Form->create('Group');?>
			<fieldset>
				<legend>Admin Edit Group</legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
