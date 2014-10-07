<?php
/**
 * Default layout.
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
		Site -
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
		echo $this->Html->meta('Latest News', '/posts/index.rss', array('type' => 'rss'));
		echo $this->Html->meta('icon');
		if (Configure::read('Google.SiteVerification.key')) {
			echo $this->Html->meta(array('name' => 'google-site-verification', 'content' => Configure::read('Google.SiteVerification.key')));
		}
		echo $this->fetch('meta');

		if (Configure::read('JqueryUi.theme')) {
			echo $this->Html->css(Configure::read('JqueryUi.theme'));
		}
		if (Configure::read('FontAwesome.version')) {
			echo $this->Html->css(Configure::read('FontAwesome.version'));
		}
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
		if (Configure::read('JqueryUi.version')) {
			echo $this->Html->script(Configure::read('JqueryUi.version'));
		}
		if (Configure::read('Bootstrap.js_version')) {
			echo $this->Html->script(Configure::read('Bootstrap.js_version'));
		}
		echo $this->Html->script(array('project.min'));
		echo $this->fetch('script');
		echo $this->element('Google/Analytics/page_tracker');
	?>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navigation">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php echo $this->Html->link('Site', '/', array('class' => 'navbar-brand')); ?>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="main-navigation">
				<?php
					$menuItems = $this->requestAction(array('controller' => 'menus', 'action' => 'menu'));
					echo $this->Menu->bootstrapMenu($menuItems);
					echo $this->element('Google/Search/search');
				?>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container -->
	</nav>

	<div class="container">
		<header id="page-header" class="page-header">
			<hgroup>
				<h1>Site <small>tagline</small></h1>
			</hgroup>
		</header>

		<?php echo $this->Session->flash('auth'); ?>
		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>

		<?php echo $this->element('sql_dump'); ?>

		<div class="top-page"><?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'fa fa-arrow-circle-o-up fa-3x')), '#page-header', array('escape' => false)); ?></div>
	</div><!-- /container -->


	<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<p><strong>Follow Us:</strong></p>
					<p>
						<?php
							echo $this->Html->link($this->Html->tag('span', '', array('class' => 'fa fa-envelope fa-3x')), array('controller' => 'contact_forms'), array('target' => '_blank', 'escape' => false));
							echo ' '.$this->Html->link($this->Html->tag('span', '', array('class' => 'fa fa-globe fa-3x')), 'http://ilmfan.com/', array('target' => '_blank', 'escape' => false));
							echo ' '.$this->Html->link($this->Html->tag('span', '', array('class' => 'fa fa-twitter-square fa-3x')), 'https://twitter.com/malducin', array('target' => '_blank', 'escape' => false));
						?>
					</p>
				</div>
				<div class="col-md-4">
					<address>
						<strong>Company name</strong><br>
						Street Address<br>
						City, State, Zip Code<br>
						Country<br>
						<span class="fa fa-phone"></span> +1 () XXX-XXXX
					</address>
				</div>
				<div class="col-md-4 embed-responsive footer-map">
					Google Map
				</div>
			</div>
		<p class="text-center">
			© 2014-<?php echo date('Y'); ?>, system by <?php echo $this->Html->link('Manuel Alducin (malducin) - VFXfan.com', 'http://vfxfan.com'); ?>
		</p>
			<p class="text-center">
				<?php
					if ($this->Session->read('Config.theme') == 'default') {
						echo $this->Html->link('Switch to Lower Bandwidth Site', array('controller' => 'change_themes', 'action' => 'change'), array('class' => 'btn btn-info'));
					} else {
						echo $this->Html->link('Switch to Default Site', array('controller' => 'change_themes', 'action' => 'change'), array('class' => 'btn btn-info'));
					}
				?>
			</p>
		</div>
	</footer>
</body>
</html>