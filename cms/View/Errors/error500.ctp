<?php
/**
 * Error 500 view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Errors
 */
?>
<h1><?php echo $message; ?></h1>
<p class="alert alert-danger">
	<strong>Error: </strong>
	An Internal Error Has Occurred.
</p>
<p class="alert alert-warning">
	There has been a serious error. We'll try to take you to the main page in a moment.
</p>

<?php
	if (Configure::read('debug') > 0):
		echo $this->element('exception_stack_trace');
	endif;
?>
<script type="text/javascript">
	function redirectHome() {
		window.location = '<?php echo Router::url(array('controller' => 'pages', 'action' => 'index')); ?>';
	}
	setTimeout('redirectHome()', 7000);
</script>
