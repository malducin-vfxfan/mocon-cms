<?php
/**
 * Menus admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.SystemInfos
 */
?>
<section>
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
				<td>Router::fullBaseUrl - App.fullBaseUrl</td>
				<td><?php echo Router::fullBaseUrl(); ?> - <?php echo Configure::read('App.fullBaseUrl'); ?>&nbsp;</td>
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
				<td>App.imageBaseUrl</td>
				<td><?php echo Configure::read('App.imageBaseUrl'); ?>&nbsp;</td>
			</tr>
			<tr>
				<td>App.cssBaseUrl</td>
				<td><?php echo Configure::read('App.cssBaseUrl'); ?>&nbsp;</td>
			</tr>
			<tr>
				<td>App.jsBaseUrl</td>
				<td><?php echo Configure::read('App.jsBaseUrl'); ?>&nbsp;</td>
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
				<td><?php echo $this->Html->link('View Admin Index', array('controller' => Inflector::underscore($controllerPresent), 'action' => 'admin_index'), array('class' => 'btn btn-default')); ?>&nbsp;</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</section>
