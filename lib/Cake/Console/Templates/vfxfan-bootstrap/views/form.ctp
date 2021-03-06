<?php
/**
 * View form template.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009, 2011, ILMfan (http://ilmfan.com)
 * @link          http://ilmfan.com ILMfan
 * @package       templates
 * @subpackage    templates.vfxfan-bootstrap.views.form
 */
$packagename = strtolower(Inflector::slug($pluralHumanName)).'.views';
?>
<?php echo "<?php\n"; ?>
/**
 * <?php echo $pluralHumanName; ?> admin view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       <?php echo $packagename."\n"; ?>
 */
<?php echo "?>\n"; ?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
<?php if (strpos($action, 'add') === false): ?>
			<li><?php echo "<?php echo \$this->Form->postLink('Delete', array('action' => 'admin_delete', \$this->Form->value('{$modelClass}.{$primaryKey}')), array('class' => 'btn btn-danger'), sprintf('Are you sure you want to delete # %s?', \$this->Form->value('{$modelClass}.{$primaryKey}'))); ?>";?></li>
<?php endif;?>
			<li><?php echo "<?php echo \$this->Html->link('List " . $pluralHumanName . "', array('action' => 'admin_index'), array('class' => 'btn'));?>";?></li>
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
	<section class="admin-content">
		<h2><?php printf("%s a %s", Inflector::humanize($action), $singularHumanName); ?></h2>
		<?php echo "<?php echo \$this->Form->create('{$modelClass}');?>\n";?>
			<fieldset>
				<legend><?php printf("%s %s", Inflector::humanize($action), $singularHumanName); ?></legend>
<?php
		echo "\t\t\t\t<?php\n";
		foreach ($fields as $field) {
			if (strpos($action, 'add') !== false && $field == $primaryKey) {
				continue;
			} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
				echo "\t\t\t\t\techo \$this->Form->input('{$field}');\n";
			}
		}
		if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
				echo "\t\t\t\t\techo \$this->Form->input('{$assocName}');\n";
			}
		}
		echo "\t\t\t\t?>\n";
?>
			</fieldset>
<?php
	echo "\t\t<?php echo \$this->Form->end('Submit');?>\n";
?>
	</section>
</div>
