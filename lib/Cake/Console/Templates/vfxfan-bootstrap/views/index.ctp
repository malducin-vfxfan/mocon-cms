<?php
/**
 * View index template.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009, 2011, ILMfan (http://ilmfan.com)
 * @link          http://ilmfan.com ILMfan
 * @package       templates
 * @subpackage    templates.vfxfan-bootstrap.views.index
 */
$packagename = strtolower(Inflector::slug($pluralHumanName));
$subpackagename = $packagename.'.views';
?>
<?php echo "<?php\n"; ?>
/**
 * <?php echo $pluralHumanName; ?> admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @subpackage    <?php echo $packagename."\n"; ?>
 * @subpackage    <?php echo $subpackagename."\n"; ?>
 */
<?php echo "?>\n"; ?>
<div class="row">
	<section class="admin-main-content">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<li><?php echo "<?php echo \$this->Html->link('New " . $singularHumanName . "', array('action' => 'admin_add'), array('class' => 'btn')); ?>";?></li>
		</ul>
	</section>
</div>
<div class="row">
	<section class="admin-main-content">
		<h2><?php echo $pluralHumanName; ?></h2>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
<?php foreach ($fields as $field): ?>
					<th><?php echo "<?php echo \$this->Paginator->sort('{$field}');?>";?></th>
<?php endforeach;?>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
<?php
	echo "\t\t\t\t<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
	echo "\t\t\t\t<tr>\n";
	foreach ($fields as $field) {
		$isKey = false;
		if (!empty($associations['belongsTo'])) {
			foreach ($associations['belongsTo'] as $alias => $details) {
				if ($field === $details['foreignKey']) {
					$isKey = true;
					echo "\t\t\t\t\t<td>\n\t\t\t\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'admin_view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t\t\t\t</td>\n";
					break;
				}
			}
		}
		if ($isKey !== true) {
			echo "\t\t\t\t\t<td><?php echo \${$singularVar}['{$modelClass}']['{$field}']; ?>&nbsp;</td>\n";
		}
	}
	echo "\t\t\t\t\t<td>\n";
	echo "\t\t\t\t\t\t<?php echo \$this->Html->link('View', array('action' => 'admin_view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn')); ?>\n";
 	echo "\t\t\t\t\t\t<?php echo \$this->Html->link('Edit', array('action' => 'admin_edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn')); ?>\n";
 	echo "\t\t\t\t\t\t<?php echo \$this->Form->postLink('Delete', array('action' => 'admin_delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
	echo "\t\t\t\t\t</td>\n";
	echo "\t\t\t\t</tr>\n";

	echo "\t\t\t\t<?php endforeach; ?>\n";
?>
			</tbody>
		</table>
		<p>
<?php echo "\t\t<?php
\t\t\techo \$this->Paginator->counter(array(
\t\t\t\t'format' => 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'
\t\t\t));
\t\t?>\n";
?>
		</p>

		<div class="paging">
<?php
	echo "\t\t<?php\n";
	echo "\t\t\techo \$this->Paginator->prev('« previous', array(), null, array('class' => 'prev disabled'));\n";
	echo "\t\t\techo \$this->Paginator->numbers(array('separator' => '', 'first' => 'first', 'last' => 'last'));\n";
	echo "\t\t\techo \$this->Paginator->next('next »', array(), null, array('class' => 'next disabled'));\n";
	echo "\t\t?>\n";
?>
		</div>
	</section>
</div>
<aside class="row">
	<section class="admin-related-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
<?php
	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
				echo "\t\t\t<li><?php echo \$this->Html->link('List " . Inflector::humanize($details['controller']) . "', array('controller' => '{$details['controller']}', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>\n";
				echo "\t\t\t<li><?php echo \$this->Html->link('New " . Inflector::humanize(Inflector::underscore($alias)) . "', array('controller' => '{$details['controller']}', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>\n";
				$done[] = $details['controller'];
			}
		}
	}
?>
		</ul>
	</section>
</aside>

