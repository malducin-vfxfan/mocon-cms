<?php
/**
 * Users admin login view.
 *
 * Users admin login view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    users
 */
?>
<div class="row">
	<section class="login">
		<?php echo $this->Form->create('User', array('class' => 'form-stacked'));?>
			<fieldset>
				<legend>Admin Login</legend>
				<?php
					echo $this->Form->input('username', array('div' => 'clearfix'));
					echo $this->Form->input('password', array('div' => 'clearfix'));
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>