<?php
/**
 * ACL Permissions admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       acl_permissions
 * @subpackage    acl_permissions.views
 */
$this->extend('/Common/admin_index');

$this->assign('formTitle', 'ACOs');

$this->start('actions');
?>
			<li><?php echo $this->Html->link('ACO Update', array('action' => 'admin_aco_update'), array('class' => 'btn')); ?></li>
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

					<td><?php echo $this->Html->link('View Permissions', array('action' => 'admin_view', $rootAco['Aco']['id']), array('class' => 'btn')); ?>&nbsp;</td>
				</tr>
				<?php foreach ($acos as $aco): ?>
				<tr>
					<td>
						<?php
							echo $aco['Aco']['alias'];
						?>
					</td>
					<td>
						<?php echo $this->Html->link('View Methods', array('action' => 'admin_methods', $aco['Aco']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Html->link('View Permissions', array('action' => 'admin_view', $aco['Aco']['id']), array('class' => 'btn')); ?>&nbsp;</td>
				</tr>
				<?php endforeach; ?>
<?php
$this->end();
?>
