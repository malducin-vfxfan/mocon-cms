<?php
/**
 * Menus admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       system_infos
 * @subpackage    system_infos.views
 */
?>
<div class="row">
	<section class="admin-main-content">
		<h2>System Info</h2>
		<h3>Basic Configuration</h3>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Setting</th>
					<th>Value</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>CakePHP Version</td>
					<td><?php echo $cakephpVersion; ?>&nbsp;</td>
				</tr>
				<tr>
					<td>PHP Version</td>
					<td><?php echo $phpVersion; ?>&nbsp;</td>
				</tr>
				<tr>
					<td>FULL_BASE_URL</td>
					<td><?php echo FULL_BASE_URL; ?>&nbsp;</td>
				</tr>
				<tr>
					<td>WEBROOT_DIR</td>
					<td><?php echo WEBROOT_DIR; ?>&nbsp;</td>
				</tr>
				<tr>
					<td>WWW_ROOT</td>
					<td><?php echo WWW_ROOT; ?>&nbsp;</td>
				</tr>
				<tr>
					<td>IMAGES</td>
					<td><?php echo IMAGES; ?>&nbsp;</td>
				</tr>
				<tr>
					<td>IMAGES URL</td>
					<td><?php echo IMAGES_URL; ?>&nbsp;</td>
				</tr>
				<tr>
					<td>CSS</td>
					<td><?php echo CSS; ?>&nbsp;</td>
				</tr>
				<tr>
					<td>CSS_URL</td>
					<td><?php echo CSS_URL; ?>&nbsp;</td>
				</tr>
				<tr>
					<td>JS</td>
					<td><?php echo JS; ?>&nbsp;</td>
				</tr>
				<tr>
					<td>JS_URL</td>
					<td><?php echo JS_URL; ?>&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<h3>Controllers</h3>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Controller Name</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($controllersPresent as $controllerPresent):
					if ($controllerPresent == 'App') continue;
			?>
				<tr>
					<td><?php echo Inflector::humanize(Inflector::underscore($controllerPresent)); ?></td>
					<td><?php echo $this->Html->link('View Admin Index', array('controller' => Inflector::underscore($controllerPresent), 'action' => 'admin_index'), array('class' => 'btn')); ?>&nbsp;</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</section>
</div>
