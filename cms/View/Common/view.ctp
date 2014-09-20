<?php
/**
 * Common view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Common
 */
?>
<article>
	<?php if ($this->fetch('contentPreviewImage')): ?>
	<header class="row">
		<div class="content-preview-image">
			<?php echo $this->fetch('contentPreviewImage'); ?>
		</div>
		<div class="content-preview">
			<h1><?php echo $this->fetch('title'); ?></h1>
			<?php if ($this->fetch('contentCreated') || $this->fetch('contentAuthor')): ?>
			<div class="content-detail text-muted">
				<p>
					<?php if ($this->fetch('contentCreated')): ?>
					<time class="date-created" datetime="<?php echo date(DATE_ATOM, strtotime($this->fetch('contentCreated'))); ?>">
						<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($this->fetch('contentCreated'))); ?>,
					</time>
					<?php endif; ?>
					<?php if ($this->fetch('contentAuthor')): ?>
					by <span class="author"><?php echo $this->fetch('contentAuthor'); ?></span>
					<?php endif; ?>
				</p>
			</div>
			<?php endif; ?>
		</div>
	</header>
	<?php else: ?>
	<header>
		<h1><?php echo $this->fetch('title'); ?></h1>
		<?php if ($this->fetch('contentCreated') || $this->fetch('contentAuthor')): ?>
		<div class="content-detail text-muted">
			<p>
				<?php if ($this->fetch('contentCreated')): ?>
				<time class="date-created" datetime="<?php echo date(DATE_ATOM, strtotime($this->fetch('contentCreated'))); ?>">
					<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($this->fetch('contentCreated'))); ?>,
				</time>
				<?php endif; ?>
				<?php if ($this->fetch('contentAuthor')): ?>
				by <span class="author"><?php echo $this->fetch('contentAuthor'); ?></span>
				<?php endif; ?>
			</p>
		</div>
		<?php endif; ?>
	</header>
	<?php endif; ?>

	<div class="contents">
		<?php echo $this->fetch('content'); ?>
	</div>
</article>

<?php if ($this->fetch('extraContent')): ?>
<?php echo $this->fetch('extraContent'); ?>
<?php endif; ?>

<?php if ($this->fetch('sectionModified')): ?>
<aside>
	<p id="content-section-modified">
		<small>
			Section last modified:
			<time class="date-modified" datetime="<?php echo date(DATE_ATOM, strtotime($this->fetch('sectionModified'))); ?>">
				<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($this->fetch('sectionModified'))); ?>
			</time>
		</small>
	</p>
</aside>
<?php endif; ?>

<?php if (isset($this->Paginator)): ?>
<aside>
	<nav class="paginator">
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
	</nav>
</aside>
<?php endif; ?>
