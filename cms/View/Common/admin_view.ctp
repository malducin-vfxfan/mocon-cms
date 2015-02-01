<?php
/**
 * Common admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Common
 */
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

<section>
	<dl>
		<?php echo $this->fetch('content'); ?>
	</dl>
</section>
<hr />

<?php echo $this->fetch('contentHtml'); ?>

<?php if ($this->fetch('relatedContent')): ?>
<aside>
	<?php echo $this->fetch('relatedContent'); ?>
</aside>
<?php endif; ?>
