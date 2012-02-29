<?php
/**
 * Pages view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       pages
 * @subpackage    pages.views
 */
?>
<div class="row">
	<article class="page-content">
		<header>
			<h1><?php echo $page['Page']['title']; ?></h1>
		</header>

		<div class="contents">
		<?php foreach ($pageSections as $pageSection): ?>
			<h2><?php echo $pageSection['PageSection']['title'];?></h2>
			<?php echo $pageSection['PageSection']['content'];?>

		<?php endforeach; ?>
		</div>
	</article>
</div>
<div class="row">
	<div class="page-content">
		<p id="page-section-modified">
			<small>
				Section last modified:
				<time class="date-modified" datetime="<?php echo date(DATE_ATOM, strtotime($pageSection['PageSection']['modified'])); ?>">
					<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($pageSection['PageSection']['modified'])); ?>
				</time>
			</small>
		</p>
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
				echo $this->Paginator->first('first');
				echo $this->Paginator->prev('« previous', array(), null, array('class' => 'disabled'));
				echo $this->Paginator->numbers(array('separator' => ''));
				echo $this->Paginator->next('next »', array(), null, array('class' => 'disabled'));
				echo $this->Paginator->last('last');
			?>
			</div>
		</nav>
	</div>
</div>
