<?php
/**
 * Contact Forms index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @subpackage    contact_forms
 * @subpackage    contact_forms.views
 */
?>
<div class="row">
	<section class="page-content" id="contact-us">
		<h1>Contact Us</h1>
		<?php echo $this->Form->create('ContactForm', array('class' => 'form-stacked'));?>
			<fieldset>
				<legend>Contact Form</legend>
				<?php
					echo $this->Form->input('name', array('div' => 'clearfix'));
					echo $this->Form->input('email', array('div' => 'clearfix', 'type' => 'email'));
					echo $this->Form->input('message', array('div' => 'clearfix', 'class' => 'span7'));
					echo $this->Recaptcha->display(array('recaptchaOptions' => array('theme' => 'white')));
				?>
			</fieldset>
		<?php echo $this->Form->end('Submit'); ?>
	</section>
</div>
