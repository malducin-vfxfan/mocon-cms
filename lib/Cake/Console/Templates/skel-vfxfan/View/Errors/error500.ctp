<?php
/**
 * Error 500 view.
 *
 * Error 500 view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    error_views
 */
?>
<div class="row">
	<div class="span12">
		<h2><?php echo $name; ?></h2>
		<p class="error">
			<strong>Error: </strong>
			An Internal Error Has Occurred.
		</p>
		<p class="notice">
			There has been a serious error. We'll try to take you to the main page in a moment.
		</p>

		<?php
			if (Configure::read('debug') > 0 ):
				echo $this->element('exception_stack_trace');
			endif;
		?>
		<script type="text/javascript">
			function redirectHome() {
				window.location = 'http://travelhq.vfxfan.com/';
			}
			setTimeout('redirectHome()', 7000);
		</script>
	</div>
</div>
