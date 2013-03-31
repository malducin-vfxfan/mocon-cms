<?php
/**
 * Common admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       views
 * @subpackage    views.common
 */
?>
<div class="row">
	<section class="admin-main-content">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<?php echo $this->fetch('actions'); ?>
		</ul>
	</section>
</div>
<div class="row">
	<section class="admin-main-content">
		<h2><?php echo $this->fetch('formTitle'); ?></h2>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<?php echo $this->fetch('tableHeaders'); ?>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php echo $this->fetch('tableRows'); ?>
			</tbody>
		</table>
		<p>
		<?php
			echo $this->Paginator->counter(array(
				'format' => 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'
			));
		?>
		</p>

		<div class="pagination">
			<ul>
			<?php
				echo $this->Paginator->prev('« previous', array('tag' => 'li', 'disabledTag' => 'span'), null, array());
				echo $this->Paginator->numbers(array('separator' => '', 'first' => 'first', 'last' => 'last', 'tag' => 'li', 'currentTag' => 'span', 'currentClass' => 'active'));
				echo $this->Paginator->next('next »', array('tag' => 'li', 'disabledTag' => 'span'), null, array());
			?>
			</ul>
		</div>
	</section>
</div>
<?php if ($this->fetch('relatedContent')): ?>
<aside class="row">
	<div class="admin-related">
		<?php echo $this->fetch('relatedContent'); ?>
	</div>
</aside>
<?php endif; ?>
<aside class="row">
<?php if ($this->fetch('relatedActions1')): ?>
	<section class="admin-related-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<?php echo $this->fetch('relatedActions1'); ?>
		</ul>
	</section>
<?php endif; ?>
<?php if ($this->fetch('relatedActions2')): ?>
	<section class="admin-related-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<?php echo $this->fetch('relatedActions2'); ?>
		</ul>
	</section>
<?php endif; ?>
<?php if ($this->fetch('relatedActions3')): ?>
	<section class="admin-related-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<?php echo $this->fetch('relatedActions3'); ?>
		</ul>
	</section>
<?php endif; ?>
<?php if ($this->fetch('relatedActions4')): ?>
	<section class="admin-related-actions">
		<h3>Actions</h3>
		<ul class="action-buttons-list">
			<?php echo $this->fetch('relatedActions4'); ?>
		</ul>
	</section>
<?php endif; ?>
</aside>
