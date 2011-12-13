<?php
/**
 * Default admin layout.
 *
 * Default admin layout.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    layouts
 */
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		TravelHQ - Admin -
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
		echo $this->Html->meta('icon');

		echo $this->Html->css('project');

		echo $this->Html->script(Configure::read('Jquery.version'));
		echo $this->Html->script(array('bootstrap-dropdown', 'nav'));
		echo $scripts_for_layout;
	?>
</head>
<body>
	<nav class="topbar" data-dropdown="dropdown">
		<div class="fill">
			<div class="container">
				<?php echo $this->Html->link('TravelHQ', '/', array('class' => 'brand')); ?>
				<ul class="nav">
					<li class="active"><?php echo $this->Html->link('Home', array('controller' => 'posts', 'action' => 'admin_index')); ?></li>
					<li class="dropdown">
						<?php echo $this->Html->link('Basic Admin', '#', array('class' => 'dropdown-toggle')); ?>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('Groups', array('controller' => 'groups', 'action' => 'admin_index')); ?></li>
							<li><?php echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'admin_index')); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<?php echo $this->Html->link('Basic Content', '#', array('class' => 'dropdown-toggle')); ?>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('Menu Items', array('controller' => 'menus', 'action' => 'admin_index')); ?></li>
							<li><?php echo $this->Html->link('Pages', array('controller' => 'pages', 'action' => 'admin_index')); ?></li>
							<li><?php echo $this->Html->link('Page Sections', array('controller' => 'page_sections', 'action' => 'admin_index')); ?></li>
							<li><?php echo $this->Html->link('Posts', array('controller' => 'posts', 'action' => 'admin_index')); ?></li>
							<li><?php echo $this->Html->link('Events', array('controller' => 'events', 'action' => 'admin_index')); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<?php echo $this->Html->link('Other Content', '#', array('class' => 'dropdown-toggle')); ?>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('Albums', array('controller' => 'albums', 'action' => 'admin_index')); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<?php echo $this->Html->link('Misc.', '#', array('class' => 'dropdown-toggle')); ?>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('Contact Form', array('controller' => 'contact_forms', 'action' => 'admin_index')); ?></li>
						</ul>
					</li>
					<li><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'admin_logout')); ?></li>
				</ul>
			</div>
		</div>
	</nav> <!-- /topbar -->

	<div class="container">
		<div class="content">
			<header class="page-header">
				<h1>TravelHQ Admin</h1>
			</header>
			<div class="row">
		        <div class="login" id="flash-messages">
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