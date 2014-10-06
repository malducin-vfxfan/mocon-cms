<?php
/**
 * Default login layout.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Layouts
 */
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		Site - Admin -
		<?php echo $this->fetch('title'); ?>
	</title>
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet' type='text/css'>
	<?php
		echo $this->Html->meta(array('name' => 'author', 'content' => Configure::read('Meta.author')));
		echo $this->Html->meta(array('name' => 'generator', 'content' => Configure::read('Meta.generator')));
		echo $this->Html->meta(array('name' => 'description', 'content' => Configure::read('Meta.description')));
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');

		if (Configure::read('Bootstrap.css_version')) {
			echo $this->Html->css(Configure::read('Bootstrap.css_version'));
			echo $this->Html->css('skin.min');
		}
		else {
			echo $this->Html->css('project.min');
		}
		echo $this->fetch('css');

		if (Configure::read('Jquery.version')) {
			echo $this->Html->script(Configure::read('Jquery.version'));
		}
		echo $this->fetch('script');
	?>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<?php echo $this->Html->link('Site', '/', array('class' => 'navbar-brand')); ?>
		</div>
	</nav>

	<div class="container">
		<header class="page-header">
			<hgroup>
				<h1>Site</h1>
				<h2>Admin Login</h2>
			</hgroup>
		</header>

		<?php echo $this->Session->flash('auth'); ?>
		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>

		<?php echo $this->element('sql_dump'); ?>
	</div><!-- /container -->

	<footer>
		<p class="text-center">
			© 2013-<?php echo date('Y'); ?>, system by <?php echo $this->Html->link('Manuel Alducin (malducin) - VFXfan.com', 'http://vfxfan.com'); ?>
		</p>
		<p class="text-center">
			<?php
				if ($this->Session->read('Config.theme') == 'default') {
					echo $this->Html->link('Switch to Mobile Site', array('controller' => 'change_themes', 'action' => 'change'), array('class' => 'btn btn-info'));
				} else {
					echo $this->Html->link('Switch to Default Site', array('controller' => 'change_themes', 'action' => 'change'), array('class' => 'btn btn-info'));
				}
			?>
		</p>
	</footer>
</body>
</html>