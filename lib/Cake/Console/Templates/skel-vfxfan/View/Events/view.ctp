<?php
/**
 * Posts view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       events
 * @subpackage    events.views
 */
?>
<div class="row">
	<article class="page-content event-contents">
		<?php echo $this->FormatImage->idImage('events/'.$event['Event']['year'], $event['Event']['id'], array('class' => 'thumbnail image-right'), 'events'); ?>
		<header>
			<h1>Event: <?php echo $event['Event']['name']; ?></h1>
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
</div>
<div class="row">
	<div class="page-content">
		<p id="post-modified">
			<small>Event last modified:
				<time class="date-modified" datetime="<?php echo date(DATE_ATOM, strtotime($event['Event']['modified'])); ?>">
					<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($event['Event']['modified'])); ?>
				</time>
			</small>
		</p>
	</div>
</div>
