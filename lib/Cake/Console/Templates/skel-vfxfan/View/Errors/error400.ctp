<?php
/**
 * Error 400 view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       errors
 * @subpackage    error.views
 */
?>
<div class="row">
	<div class="span12">
		<h1><?php echo $name; ?></h1>
		<p class="alert alert-error">
			<strong>Error:</strong>
			<?php
				echo sprintf('The requested address <strong>%s</strong> was not found on this server.', $url);
			?>
		</p>
		<p class="alert">
			The location you're looking for has been lost somehwere in the world,
			or the form you were using may have expired.
			Check the address, reload the form or report the error.
			We'll take you to the main page in a moment.
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
