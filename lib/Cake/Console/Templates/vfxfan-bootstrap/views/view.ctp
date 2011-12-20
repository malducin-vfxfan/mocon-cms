<?php
/**
 * View view template.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009, 2011, ILMfan (http://ilmfan.com)
 * @link          http://ilmfan.com ILMfan
 * @package       templates
 * @subpackage    templates.vfxfan-bootstrap.views.view
 */
$packagename = strtolower(Inflector::slug($pluralHumanName));
$subpackagename = $packagename.'.views';
?>
<?php echo "<?php\n"; ?>
/**
 * <?php echo $pluralHumanName; ?> admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @subpackage    <?php echo $packagename."\n"; ?>
 * @subpackage    <?php echo $subpackagename."\n"; ?>
 */
<?php echo "?>\n"; ?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
<?php
	echo "\t\t\t<li><?php echo \$this->Html->link('Edit " . $singularHumanName ."', array('action' => 'admin_edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn')); ?> </li>\n";
	echo "\t\t\t<li><?php echo \$this->Form->postLink('Delete " . $singularHumanName . "', array('action' => 'admin_delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn danger'), sprintf('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?> </li>\n";
	echo "\t\t\t<li><?php echo \$this->Html->link('List " . $pluralHumanName . "', array('action' => 'admin_index'), array('class' => 'btn')); ?> </li>\n";
	echo "\t\t\t<li><?php echo \$this->Html->link('New " . $singularHumanName . "', array('action' => 'admin_add'), array('class' => 'btn')); ?> </li>\n";

	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
				echo "\t\t\t<li><?php echo \$this->Html->link('List " . Inflector::humanize($details['controller']) . "', array('controller' => '{$details['controller']}', 'action' => 'admin_index'), array('class' => 'btn')); ?> </li>\n";
				echo "\t\t\t<li><?php echo \$this->Html->link('New " .  Inflector::humanize(Inflector::underscore($alias)) . "', array('controller' => '{$details['controller']}', 'action' => 'admin_add'), array('class' => 'btn')); ?> </li>\n";
				$done[] = $details['controller'];
			}
		}
	}
?>
		</ul>
	</section>
	<section class="admin-content">
		<h2><?php echo $singularHumanName; ?></h2>
		<dl>
<?php
foreach ($fields as $field) {
	$isKey = false;
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $alias => $details) {
			if ($field === $details['foreignKey']) {
				$isKey = true;
				echo "\t\t\t<dt>" . Inflector::humanize(Inflector::underscore($alias)) . "</dt>\n";
				echo "\t\t\t<dd>\n\t\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'admin_view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t\t\t&nbsp;\n\t\t\t</dd>\n";
				break;
			}
		}
	}
	if ($isKey !== true) {
		echo "\t\t\t<dt>" . Inflector::humanize($field) . "</dt>\n";
		echo "\t\t\t<dd>\n\t\t\t\t<?php echo \${$singularVar}['{$modelClass}']['{$field}']; ?>\n\t\t\t\t&nbsp;\n\t\t\t</dd>\n";
	}
}
?>
		</dl>
	</section>
</div>
<?php
if (!empty($associations['hasOne'])) :
	foreach ($associations['hasOne'] as $alias => $details): ?>
<div class="row">
	<aside class="admin-related">
		<h3><?php echo "Related " . Inflector::humanize($details['controller']); ?></h3>
	<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n";?>
		<dl>
	<?php
		foreach ($details['fields'] as $field) {
			echo "\t\t\t<dt><?php echo '" . Inflector::humanize($field) . "';?></dt>\n";
			echo "\t\t\t<dd>\n\t\t\t\t<?php echo \${$singularVar}['{$alias}']['{$field}'];?>\n&nbsp;</dd>\n";
		}
	?>
		</dl>
	<?php echo "\t\t<?php endif; ?>\n";?>
		<section class="admin-view-related-actions">
			<ul class="action-buttons-list">
				<li><?php echo "<?php echo \$this->Html->link('Edit " . Inflector::humanize(Inflector::underscore($alias)) . "', array('controller' => '{$details['controller']}', 'action' => 'admin_edit', \${$singularVar}['{$alias}']['{$details['primaryKey']}']), array('class' => 'btn')); ?></li>\n";?>
			</ul>
		</section>
	</aside>
</div>
	<?php
	endforeach;
endif;
if (empty($associations['hasMany'])) {
	$associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
	$associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
$i = 0;
foreach ($relations as $alias => $details):
	$otherSingularVar = Inflector::variable($alias);
	$otherPluralHumanName = Inflector::humanize($details['controller']);
	?>
<div class="row">
	<aside class="admin-related">
		<h3><?php echo "Related " . $otherPluralHumanName; ?></h3>
		<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n";?>
		<table class="bordered-table zebra-striped">
			<tr>
<?php
	foreach ($details['fields'] as $field) {
		echo "\t\t\t\t<th><?php echo '" . Inflector::humanize($field) . "'; ?></th>\n";
	}
?>
				<th>Actions</th>
			</tr>
<?php
	echo "\t\t\t<?php\n";
	echo "\t\t\t\t\$i = 0\n";
	echo "\t\t\t\tforeach (\${$singularVar}['{$alias}'] as \${$otherSingularVar}):\n";
	echo "\t\t\t?>\n";
	echo "\t\t\t<tr>\n";

	foreach ($details['fields'] as $field) {
		echo "\t\t\t\t<td><?php echo \${$otherSingularVar}['{$field}'];?></td>\n";
	}

	echo "\t\t\t\t<td>\n";
	echo "\t\t\t\t\t<?php echo \$this->Html->link('View', array('controller' => '{$details['controller']}', 'action' => 'admin_view', \${$otherSingularVar}['{$details['primaryKey']}']), array('class' => 'btn')); ?>\n";
	echo "\t\t\t\t\t<?php echo \$this->Html->link('Edit', array('controller' => '{$details['controller']}', 'action' => 'admin_edit', \${$otherSingularVar}['{$details['primaryKey']}']), array('class' => 'btn')); ?>\n";
	echo "\t\t\t\t\t<?php echo \$this->Form->postLink('Delete', array('controller' => '{$details['controller']}', 'action' => 'admin_delete', \${$otherSingularVar}['{$details['primaryKey']}']), array('class' => 'btn danger'), sprintf('Are you sure you want to delete # %s?', \${$otherSingularVar}['{$details['primaryKey']}'])); ?>\n";
	echo "\t\t\t\t</td>\n";
	echo "\t\t\t</tr>\n";

	echo "\t\t\t<?php endforeach; ?>\n";
?>
		</table>

		<p>
<?php
	echo "\t\t<?php\n";
	echo "\t\t\techo \$this->Paginator->counter(array(\n";
	echo "\t\t\t\t'format' => 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'\n";
	echo "\t\t\t));\n";
	echo "\t\t?>\n";
?>
		</p>

		<div class="paging">
<?php
	echo "\t\t<?php\n";
	echo "\t\t\techo \$this->Paginator->first('first');\n";
	echo "\t\t\techo \$this->Paginator->prev('« previous', array(), null, array('class' => 'prev disabled'));\n";
	echo "\t\t\techo \$this->Paginator->numbers(array('separator' => ''));\n";
	echo "\t\t\techo \$this->Paginator->next('next »', array(), null, array('class' => 'next disabled'));\n";
	echo "\t\t\techo \$this->Paginator->last('last');\n";
	echo "\t\t?>\n";
?>
		</div>
		<?php echo "<?php endif; ?>\n\n";?>
		<section class="admin-view-related-actions">
			<ul class="action-buttons-list">
				<li><?php echo "<?php echo \$this->Html->link('New " . Inflector::humanize(Inflector::underscore($alias)) . "', array('controller' => '{$details['controller']}', 'action' => 'admin_add'), array('class' => 'btn'));?>";?> </li>
			</ul>
		</section>
	</aside>
</div>
<?php endforeach;?>
