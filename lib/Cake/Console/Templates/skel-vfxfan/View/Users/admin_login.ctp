<?php
/**
 * Users admin login view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Users
 */
?>
<section id="login">
	<?php
		echo $this->Form->create('User', array(
			'inputDefaults' => array(
				'div' => array('class' => 'form-group'),
				'label' => array('class' => 'control-label'),
				'class' => 'form-control',
				'error' => array(
					'attributes' => array('class' => 'text-danger')
				)
			)
		));
	?>
	<fieldset>
		<legend>Admin Login</legend>
		<?php
			echo $this->Form->input('username');
			echo $this->Form->input('password');
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label' => 'Login', 'class' => 'btn btn-primary')); ?>
</section>
