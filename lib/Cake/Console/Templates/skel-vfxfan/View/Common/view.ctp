<?php
/**
 * Common view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       views
 * @subpackage    views.common
 */
?>
<div class="row">
	<article class="page-content">
		<?php
			if ($this->fetch('contentThumbnail')) {
				echo $this->fetch('contentThumbnail');
			}
		?>
		<header>
			<h1><?php echo $this->fetch('title'); ?></h1>
			<?php if ($this->fetch('contentCreated')): ?>
			<time class="date-created" datetime="<?php echo date(DATE_ATOM, strtotime($this->fetch('contentCreated'))); ?>">
				<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($this->fetch('contentCreated'))); ?>
			</time>
			<?php endif; ?>
			<?php if ($this->fetch('contentStartDate')): ?>
			<time class="date-start" datetime="<?php echo $this->fetch('contentStartDate'); ?>">
				<?php echo strftime("%B %d, %Y", strtotime($this->fetch('contentStartDate'))); ?>
			</time>
			<?php endif; ?>
			<?php if ($this->fetch('contentEndDate')): ?>
			-
			<time class="date-end" datetime="<?php echo $this->fetch('contentEndDate') ?>">
				<?php echo strftime("%B %d, %Y", strtotime($this->fetch('contentEndDate'))); ?>
			</time>
			<?php endif; ?>
			<?php if ($this->fetch('contentAuthor')): ?>
			<p>by <span class="author"><?php echo $this->fetch('contentAuthor'); ?></span></p>
			<?php endif; ?>
		</header>

		<div class="contents">
			<?php echo $this->fetch('content'); ?>
		</div>
	</article>
</div>

<?php if ($this->fetch('extraContent')): ?>
<?php echo $this->fetch('extraContent'); ?>
<?php endif; ?>

<?php if ($this->fetch('sectionModified')): ?>
<div class="row">
	<div class="page-content">
		<p id="content-section-modified">
			<small>
				Section last modified:
				<time class="date-modified" datetime="<?php echo date(DATE_ATOM, strtotime($this->fetch('sectionModified'))); ?>">
					<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($this->fetch('sectionModified'))); ?>
				</time>
			</small>
		</p>
	</div>
</div>
<?php endif; ?>
<?php if (isset($this->Paginator)): ?>
<div class="row">
	<div class="page-content">
		<nav class="paginator">
			<p>
			<?php
				echo $this->Paginator->counter(array(
					'format' => 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'
				));
			?>
			</p>

			<div class="paging">
			<?php
				echo $this->Paginator->prev('« previous', array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => '', 'first' => 'first', 'last' => 'last'));
				echo $this->Paginator->next('next »', array(), null, array('class' => 'next disabled'));
			?>
			</div>
		</nav>
	</div>
</div>
<?php endif; ?>