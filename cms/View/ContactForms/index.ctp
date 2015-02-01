<?php
/**
 * Contact Forms index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.ContactForms
 */
$this->Html->script('https://www.google.com/recaptcha/api.js', array('inline' => false, 'async', 'defer'));
?>
<section id="contact-us">
	<h1>Contact Us</h1>
	<?php
		echo $this->Form->create('ContactForm', array(
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
			<legend>Contact Form</legend>
			<?php
				echo $this->Form->input('name');
				echo $this->Form->input('email', array('type' => 'email'));
				echo $this->Form->input('message');
				echo $this->SimpleRecaptcha->widget();
			?>
		</fieldset>
	<?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'btn btn-primary')); ?>
</section>
