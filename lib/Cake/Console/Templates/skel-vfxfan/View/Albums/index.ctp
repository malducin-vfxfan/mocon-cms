<?php
/**
 * Albums admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @subpackage    albums
 * @subpackage    albums.views
 */
?>
<div class="row">
	<section class="page-content" id="albums">
		<h1>Albums</h1>

		<?php foreach ($albums as $album): ?>
		<article class="album-contents">
			<?php echo $this->FormatImage->idImage('albums', $album['Album']['id'], array('class' => 'framed image-right')); ?>
			<header>
				<h2><?php echo $album['Album']['name']; ?></h2>
				<time class="date-created" datetime="<?php echo date(DATE_ATOM, strtotime($album['Album']['created'])); ?>">
					<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($album['Album']['created'])); ?>
				</time>
			</header>
			<p><?php echo $album['Album']['description']; ?></p>
			<p><?php echo $this->Html->link('View album »', array('controller' => 'albums', 'action' => 'view', $album['Album']['slug'])); ?></p>
		</article>
		<hr />
		<?php endforeach; ?>
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
				echo $this->Paginator->prev('« previous', array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => ''));
				echo $this->Paginator->next('next »', array(), null, array('class' => 'next disabled'));
				echo $this->Paginator->last('last');
			?>
			</div>
		</nav>
	</section>
</div>
