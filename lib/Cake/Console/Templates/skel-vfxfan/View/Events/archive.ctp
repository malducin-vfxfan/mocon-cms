<?php
/**
 * Events admin index view.
 *
 * Events admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @subpackage    events
 * @subpackage    events.views
 */
?>
<div class="row">
	<section class="page-content" id="events">
		<h1>Past Events</h1>

		<?php foreach ($events as $event): ?>
		<article class="contents" id="event-contents">
			<figure class="image-right"><?php echo $this->FormatImage->idImage('events', $event['Event']['id']); ?></figure>
			<h2><?php echo $event['Event']['name']; ?></h2>
			<div class="content-info">
				<time class="date-start" datetime="<?php echo $event['Event']['date_start']; ?>">
					<?php echo strftime("%B %d, %Y", strtotime($event['Event']['date_start'])); ?>
				</time>
				-
				<time class="date-end" datetime="<?php echo $event['Event']['date_end']; ?>">
					<?php echo strftime("%B %d, %Y", strtotime($event['Event']['date_end'])); ?>
				</time>
				<p>@ <span class="event-location"><?php echo $event['Event']['location']; ?></span>
				<?php if ($event['Event']['webpage']): ?>
					<br />
					Web: <?php echo $this->Html->link($event['Event']['webpage'], $event['Event']['webpage'], array('target' => '_blank')); ?></p>
				<?php endif; ?>
				</p>
			</div>
			<p><?php echo $event['Event']['description']; ?></p>
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
