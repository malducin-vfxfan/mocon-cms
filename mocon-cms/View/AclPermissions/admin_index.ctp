<?php
/**
 * ACL Permissions admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.AclPermissions
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'ACOs');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('ACO Update', array('action' => 'admin_aco_update')); ?></li>
<?php
$this->end();

$this->start('tableHeaders');
?>
					<th>ACO Path</th>
<?php
$this->end();

$this->start('tableRows');
?>
				<tr>
					<td>
						<?php
							echo $rootAco['Aco']['alias'];
						?>
					</td>

					<td><?php echo $this->Html->link('View Permissions', array('action' => 'admin_view', $rootAco['Aco']['id']), array('class' => 'btn btn-default')); ?>&nbsp;</td>
				</tr>
				<?php foreach ($acos as $aco): ?>
				<tr>
					<td>
						<?php
							echo $aco['Aco']['alias'];
						?>
					</td>
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								Action <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><?php echo $this->Html->link('View Methods', array('action' => 'admin_methods', $aco['Aco']['id'])); ?></li>
								<li><?php echo $this->Html->link('View Permissions', array('action' => 'admin_view', $aco['Aco']['id'])); ?></li>
					</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();
?>
