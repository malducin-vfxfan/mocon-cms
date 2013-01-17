<?php
/**
 * Default login layout.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       app
 * @subpackage    app.views.layouts.default.login
 */
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		Site - Admin -
		<?php echo $title_for_layout; ?>
	</title>
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<?php
		echo $this->Html->meta(array('name' => 'author', 'content' => Configure::read('Meta.author')));
		echo $this->Html->meta(array('name' => 'generator', 'content' => Configure::read('Meta.generator')));
		echo $this->Html->meta(array('name' => 'description', 'content' => Configure::read('Meta.description')));
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');

		echo $this->Html->css('project');
		echo $this->fetch('css');

		if (Configure::read('Jquery.version')) {
			echo $this->Html->script(Configure::read('Jquery.version'));
		}
		echo $this->fetch('script');
	?>
</head>
<body style="background: #fff;">
	<nav class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<?php echo $this->Html->link('Site', '/', array('class' => 'brand')); ?>
			</div>
		</div>
	</nav> <!-- /topbar -->

	<div class="container">
		<div class="body-content">
			<div class="row">
				<header class="span12">
					<hgroup>
						<h1>Site</h1>
						<h2>Admin Login</h2>
					</hgroup>
				</header>
			</div>
			<div class="row">
		        <div class="login" id="flash-messages">
					<?php echo $this->Session->flash('auth'); ?>
					<?php echo $this->Session->flash(); ?>
				</div>
			</div>

			<?php echo $this->fetch('content'); ?>

			<div class="row">
				<div class="span12">
					<?php echo $this->element('sql_dump'); ?>
				</div>
			</div>
		</div>
		<!-- /body-content -->
		<footer>
			<p>
				© 2013-<?php echo date('Y'); ?>, system by <?php echo $this->Html->link('Manuel Alducin (malducin) - VFXfan.com', 'http://vfxfan.com'); ?></p>
				<?php
					if ($this->Session->read('Config.theme') == 'default') {
						echo $this->Html->link('Switch to Mobile Site', array('controller' => 'change_themes', 'action' => 'change'), array('class' => 'btn btn-info'));
					}
					else {
						echo $this->Html->link('Switch to Default Site', array('controller' => 'change_themes', 'action' => 'change'), array('class' => 'btn btn-info'));
					}
				?>
			</p>
		</footer>
	</div> <!-- /container -->
</body>
</html>