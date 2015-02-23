<?php
/**
 * Posts admin add view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.Posts
 */
if (Configure::read('TinyMCE.active')) {
	echo $this->element('TinyMCE/config_basic');
}

$this->extend('/Common/admin_add_edit');

$this->assign('formTitle', 'Add a Post');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('List Posts', array('action' => 'admin_index')); ?></li>
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
				<legend>Admin Add Post</legend>
				<?php
					echo $this->Form->input('title');
					echo $this->Form->input('summary');
					echo $this->Form->input('content');
					echo $this->Form->input('File.image', array('type' => 'file'));
				?>
			</fieldset>
		<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
