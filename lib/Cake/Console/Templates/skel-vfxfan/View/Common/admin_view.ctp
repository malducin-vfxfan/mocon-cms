<?php
/**
 * Common admin view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       views
 * @subpackage    views.common
 */
?>
<div class="row">
	<section class="admin-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<?php echo $this->fetch('actions'); ?>
		</ul>
	</section>
	<section class="admin-content">
	<h2><?php echo $this->fetch('formTitle'); ?></h2>
		<dl>
			<?php echo $this->fetch('content'); ?>
		</dl>
	</section>
</div>

<?php echo $this->fetch('contentHtml'); ?>

<?php if ($this->fetch('relatedContent1')): ?>
<div class="row">
	<aside class="admin-related">
		<?php echo $this->fetch('relatedContent1'); ?>
	</aside>
</div>
<?php endif; ?>
<?php if ($this->fetch('relatedContent2')): ?>
<div class="row">
	<aside class="admin-related">
		<?php echo $this->fetch('relatedContent2'); ?>
	</aside>
</div>
<?php endif; ?>
<?php if ($this->fetch('relatedContent3')): ?>
<div class="row">
	<aside class="admin-related">
		<?php echo $this->fetch('relatedContent3'); ?>
	</aside>
</div>
<?php endif; ?>
<?php if ($this->fetch('relatedContent4')): ?>
<div class="row">
	<aside class="admin-related">
		<?php echo $this->fetch('relatedContent4'); ?>
	</aside>
</div>
<?php endif; ?>
<?php if ($this->fetch('relatedContent5')): ?>
<div class="row">
	<aside class="admin-related">
		<?php echo $this->fetch('relatedContent5'); ?>
	</aside>
</div>
<?php endif; ?>
