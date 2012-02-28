<?php
/**
 * Error 500 view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       errors
 * @subpackage    errors.views
 */
?>
<div class="row">
	<div class="span12">
		<h1><?php echo $name; ?></h1>
		<p class="alert alert-error">
			<strong>Error: </strong>
			An Internal Error Has Occurred.
		</p>
		<p class="alert">
			There has been a serious error. We'll try to take you to the main page in a moment.
		</p>

		<?php
			if (Configure::read('debug') > 0 ):
				echo $this->element('exception_stack_trace');
			endif;
		?>
		<script type="text/javascript">
			function redirectHome() {
				window.location = '<?php echo FULL_BASE_URL; ?>';
			}
			setTimeout('redirectHome()', 7000);
		</script>
	</div>
</div>
