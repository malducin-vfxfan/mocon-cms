<?php
/**
 * Users admin login view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       users
 * @subpackage    users.views
 */
?>
<div class="row">
	<section class="login">
		<?php echo $this->Form->create('User');?>
			<fieldset>
				<legend>Admin Login</legend>
				<?php
					echo $this->Form->input('username');
					echo $this->Form->input('password');
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit');?>
	</section>
</div>