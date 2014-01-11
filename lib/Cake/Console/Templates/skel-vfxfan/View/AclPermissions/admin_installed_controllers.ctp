<?php
/**
 * ACL Permissions admin installed controllers view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.AclPermissions.View
 */
?>
<section>
	<h2>Installed Controllers and Plugins</h2>
	<h3>Controllers</h3>
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>Controller Name</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($controllers as $controller):
		?>
			<tr>
				<td><?php echo Inflector::humanize(Inflector::underscore($controller)); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<h3>Plugins</h3>
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>Plugin Name</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($plugins as $plugin):
		?>
			<tr>
				<td><?php echo Inflector::humanize(Inflector::underscore($plugin)); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<h3>Plugins Controllers</h3>
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>Plugin Controller Name</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($pluginControllers as $pluginController):
		?>
			<tr>
				<td><?php echo Inflector::humanize(Inflector::underscore($pluginController)); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</section>
