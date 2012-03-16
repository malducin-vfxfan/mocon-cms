<?php
/**
 * Default admin layout.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       app
 * @subpackage    app.views.layouts.default.admin
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
		echo $this->Html->meta(array('name' => 'author', 'content' => 'Manuel Alducin'));
		echo $this->Html->meta(array('name' => 'generator', 'content' => 'VFXfan CMS'));
		echo $this->Html->meta(array('name' => 'keywords', 'content' => Configure::read('Meta.keywords')));
		echo $this->Html->meta(array('name' => 'description', 'content' => Configure::read('Meta.description')));
		echo $this->fetch('meta');

		echo $this->Html->css('project');
		echo $this->fetch('css');

		if (Configure::read('Jquery.version')) {
			echo $this->Html->script(Configure::read('Jquery.version'));
		}
		echo $this->Html->script(array('bootstrap-dropdown', 'admin'));
		echo $this->fetch('script');
	?>
</head>
<body>
	<nav class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<?php echo $this->Html->link('Site', '/', array('class' => 'brand')); ?>
				<ul class="nav">
					<li class="dropdown">
						<?php echo $this->Html->link('Basic Admin'.$this->Html->tag('span', '', array('class' => 'caret')), '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false)); ?>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('Groups', array('controller' => 'groups', 'action' => 'admin_index')); ?></li>
							<li><?php echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'admin_index')); ?></li>
							<li><?php echo $this->Html->link('System Info', array('controller' => 'system_infos', 'action' => 'admin_index')); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<?php echo $this->Html->link('Basic Content'.$this->Html->tag('span', '', array('class' => 'caret')), '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false)); ?>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('Menu Items', array('controller' => 'menus', 'action' => 'admin_index')); ?></li>
							<li><?php echo $this->Html->link('Pages', array('controller' => 'pages', 'action' => 'admin_index')); ?></li>
							<li><?php echo $this->Html->link('Page Sections', array('controller' => 'page_sections', 'action' => 'admin_index')); ?></li>
							<li><?php echo $this->Html->link('Posts', array('controller' => 'posts', 'action' => 'admin_index')); ?></li>
							<li><?php echo $this->Html->link('Events', array('controller' => 'events', 'action' => 'admin_index')); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<?php echo $this->Html->link('Other Content'.$this->Html->tag('span', '', array('class' => 'caret')), '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false)); ?>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('Albums', array('controller' => 'albums', 'action' => 'admin_index')); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<?php echo $this->Html->link('Misc.'.$this->Html->tag('span', '', array('class' => 'caret')), '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false)); ?>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('Contact Form', array('controller' => 'contact_forms', 'action' => 'admin_index')); ?></li>
							<li><?php echo $this->Html->link('Contact Form Emails', array('controller' => 'contact_form_emails', 'action' => 'admin_index')); ?></li>
						</ul>
					</li>
					<li><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'admin_logout')); ?></li>
				</ul>
			</div>
		</div>
	</nav> <!-- /topbar -->

	<div class="container">
		<div class="body-content">
			<header class="page-header">
				<hgroup>
					<h1>Site</h1>
					<h2>Admin</h2>
				</hgroup>
			</header>
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
		<footer>
			<p>© 2011-<?php echo date('Y'); ?>, system by <?php echo $this->Html->link('Manuel Alducin (malducin) - VFXfan.com', 'http://vfxfan.com'); ?></p>
		</footer>
	</div> <!-- /container -->
</body>
</html>