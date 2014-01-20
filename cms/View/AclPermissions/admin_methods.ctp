<?php
/**
 * Pages admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.AclPermissions
 */
$this->extend('/Common/admin_view');

$this->assign('formTitle', 'Methods - Controller ACOs');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('ACO Update', array('action' => 'admin_aco_update')); ?></li>
			<li><?php echo $this->Html->link('List ACOs', array('action' => 'admin_index')); ?></li>
<?php
$this->end();
?>
			<dt>Controller Path</dt>
			<dd>
				<?php echo $completePath; ?>
				&nbsp;
			</dd>
<?php
$this->start('relatedContent');
?>
		<h3>Methods</h3>
		<?php if (!empty($controllerMethods)): ?>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Id</th>
					<th>Parent Id</th>
					<th>Method Name (Alias)</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($controllerMethods as $controllerMethod): ?>
				<tr>
					<td><?php echo $controllerMethod['Aco']['id']; ?></td>
					<td><?php echo $controllerMethod['Aco']['parent_id']; ?></td>
					<td><?php echo $controllerMethod['Aco']['alias'] ?></td>
					<td>
						<?php echo $this->Html->link('View Permissions', array('action' => 'admin_view', $controllerMethod['Aco']['id']), array('class' => 'btn btn-default')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
<?php
$this->end();
?>
