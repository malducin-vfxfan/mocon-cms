<?php
/**
 * Default layout.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       app
 * @subpackage    app.views.layouts.default
 */
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		Site -
		<?php echo $title_for_layout; ?>
	</title>
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<?php
		echo $this->Html->meta(array('name' => 'author', 'content' => 'Manuel Alducin'));
		echo $this->Html->meta(array('name' => 'generator', 'content' => 'VFXfan CMS'));
		echo $this->Html->meta(array('name' => 'keywords', 'content' => Configure::read('Meta.keywords')));
		echo $this->Html->meta(array('name' => 'description', 'content' => Configure::read('Meta.description')));
		echo $this->Html->meta('Latest News', '/posts/index.rss', array('type' => 'rss'));
		echo $this->Html->meta('icon');

		echo $this->Html->css('project');

		if (Configure::read('Jquery.version')) {
			echo $this->Html->script(Configure::read('Jquery.version'));
		}
		echo $this->Html->script(array('bootstrap-dropdown', 'nav'));
		echo $scripts_for_layout;
		echo $this->element('GoogleAnalytics/page_tracker');
	?>
</head>
<body>
	<nav class="topbar" data-dropdown="dropdown">
		<div class="fill">
			<div class="container">
				<?php echo $this->Html->link('Site', '/', array('class' => 'brand')); ?>
				<?php echo $this->element('Menus/bootstrap'); ?>
				<?php echo $this->element('GoogleSearch/simple_search'); ?>
			</div>
		</div>
	</nav> <!-- /topbar -->

	<div class="container">
		<div class="content">
			<header class="page-header">
				<hgroup>
					<h1>Site</h1>
					<h2>tagline</h2>
				</hgroup>
			</header>
			<div class="row">
		        <div class="page-content" id="flash-messages">
					<?php echo $this->Session->flash('auth'); ?>
					<?php echo $this->Session->flash(); ?>
				</div>
			</div>

			<?php echo $content_for_layout; ?>

	        <div class="row">
				<div class="span12">
					<?php echo $this->element('sql_dump'); ?>
				</div>
			</div>
		</div>
		<footer>
			<p>© 2011-<?php echo date('Y'); ?>, Manuel Alducin, <?php echo $this->Html->link('VFXfan.com', 'http://vfxfan.com'); ?></p>
		</footer>
	</div> <!-- /container -->
</body>
</html>