<?php
/**
 * Events admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       events
 * @subpackage    events.views
 */
?>
<div class="row">
	<section class="page-content" id="events">
		<h1>Upcoming Events</h1>

		<?php foreach ($events as $event): ?>
		<article class="event-contents">
			<?php echo $this->FormatImage->idImage('events/'.$event['Event']['year'], $event['Event']['id'], array('class' => 'thumbnail image-right'), 'events'); ?>
			<header>
				<h2><?php echo $event['Event']['name']; ?></h2>
				<time class="date-start" datetime="<?php echo $event['Event']['date_start']; ?>">
					<?php echo strftime("%B %d, %Y", strtotime($event['Event']['date_start'])); ?>
				</time>
				-
				<time class="date-end" datetime="<?php echo $event['Event']['date_end']; ?>">
					<?php echo strftime("%B %d, %Y", strtotime($event['Event']['date_end'])); ?>
				</time>
				<p>@ <span class="event-location"><?php echo $event['Event']['location']; ?></span></p>
			</header>
			<p><?php echo $event['Event']['description']; ?></p>
			<?php if ($event['Event']['webpage']): ?>
				<p>Web: <?php echo $this->Html->link($event['Event']['webpage'], $event['Event']['webpage'], array('target' => '_blank')); ?></p>
			<?php endif; ?>
		</article>
		<hr />
		<?php endforeach; ?>
		<p><?php echo $this->Html->link('Previous events »', array('controller' => 'events', 'action' => 'archive')); ?></p>
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
	</section>
</div>
