<?php
/**
 * Default admin layout.
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

		if (Configure::read('Bootstrap.css_version')) {
			echo $this->Html->css(Configure::read('Bootstrap.css_version'));
		}
		echo $this->Html->css('skin.min');
		if (Configure::read('JqueryUi.theme')) {
			echo $this->Html->css(Configure::read('JqueryUi.theme'));
		}
		echo $this->fetch('css');

		if (Configure::read('Jquery.version')) {
			echo $this->Html->script(Configure::read('Jquery.version'));
		}
		if (Configure::read('JqueryUi.version')) {
			echo $this->Html->script(Configure::read('JqueryUi.version'));
		}
		echo $this->Html->script(array('admin.min'));
		echo $this->fetch('script');
	?>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
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
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<?php echo $this->Html->link('Basic Admin'.$this->Html->tag('span', '', array('class' => 'caret')), '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escapeTitle' => false)); ?>
					<ul class="dropdown-menu">
						<li><?php echo $this->Html->link('Groups', array('controller' => 'groups', 'action' => 'admin_index')); ?></li>
						<li><?php echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'admin_index')); ?></li>
						<li><?php echo $this->Html->link('ACL Permissions', array('controller' => 'acl_permissions', 'action' => 'admin_index')); ?></li>
						<li><?php echo $this->Html->link('System Info', array('controller' => 'system_infos', 'action' => 'admin_index')); ?></li>
					</ul>
				</li>
				<li class="dropdown">
					<?php echo $this->Html->link('Basic Content'.$this->Html->tag('span', '', array('class' => 'caret')), '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escapeTitle' => false)); ?>
					<ul class="dropdown-menu">
						<li><?php echo $this->Html->link('Menu Items', array('controller' => 'menus', 'action' => 'admin_index')); ?></li>
						<li><?php echo $this->Html->link('Pages', array('controller' => 'pages', 'action' => 'admin_index')); ?></li>
						<li><?php echo $this->Html->link('Page Sections', array('controller' => 'page_sections', 'action' => 'admin_index')); ?></li>
						<li><?php echo $this->Html->link('Posts', array('controller' => 'posts', 'action' => 'admin_index')); ?></li>
						<li><?php echo $this->Html->link('Events', array('controller' => 'events', 'action' => 'admin_index')); ?></li>
					</ul>
				</li>
				<li class="dropdown">
					<?php echo $this->Html->link('Other Content'.$this->Html->tag('span', '', array('class' => 'caret')), '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escapeTitle' => false)); ?>
					<ul class="dropdown-menu">
						<li><?php echo $this->Html->link('Albums', array('controller' => 'albums', 'action' => 'admin_index')); ?></li>
					</ul>
				</li>
				<li class="dropdown">
					<?php echo $this->Html->link('Misc.'.$this->Html->tag('span', '', array('class' => 'caret')), '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escapeTitle' => false)); ?>
					<ul class="dropdown-menu">
						<li><?php echo $this->Html->link('Contact Form', array('controller' => 'contact_forms', 'action' => 'admin_index')); ?></li>
						<li><?php echo $this->Html->link('Contact Form Emails', array('controller' => 'contact_form_emails', 'action' => 'admin_index')); ?></li>
					</ul>
				</li>
				<li><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'admin_logout')); ?></li>
			</ul>
		</div>
	</nav>

	<div class="container">
		<header class="page-header">
			<hgroup>
				<h1>Site Admin</h1>
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