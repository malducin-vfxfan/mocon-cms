<?php
/**
 * Common admin add and edit view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Common
 */
if (Configure::read('TinyMCE.active')) {
	echo $this->element('TinyMCE/config_basic');
}
?>
<section class="page-header">
	<div class="btn-group pull-right">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			Actions <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<?php echo $this->fetch('actions'); ?>
			<?php if ($this->fetch('relatedActions')): ?>
			<li class="divider"></li>
			<?php echo $this->fetch('relatedActions'); ?>
			<?php endif; ?>
		</ul>
	</div>
	<h2><?php echo $this->fetch('formTitle'); ?></h2>
</section>

<?php echo $this->fetch('content'); ?>

<?php if ($this->fetch('relatedContent')): ?>
<aside>
	<?php echo $this->fetch('relatedContent'); ?>
</aside>
<?php endif; ?>
