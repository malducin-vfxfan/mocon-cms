<?php
/**
 * Common admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.Common
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

	<ul class="pagination">
	<?php
		echo $this->Paginator->prev('« previous', array('tag' => 'li', 'disabledTag' => 'span'), null, array());
		echo $this->Paginator->numbers(array('separator' => '', 'first' => 'first', 'last' => 'last', 'tag' => 'li', 'currentTag' => 'span', 'currentClass' => 'active'));
		echo $this->Paginator->next('next »', array('tag' => 'li', 'disabledTag' => 'span'), null, array());
	?>
	</ul>
</section>

<?php if ($this->fetch('relatedContent')): ?>
<aside>
	<?php echo $this->fetch('relatedContent'); ?>
</aside>
<?php endif; ?>
