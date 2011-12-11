<?php
/**
 * Latest Events element.
 *
 * Calls the latest_events methos of the events system to get a short
 * list of events to display (mainly in the main page).
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       events
 * @subpackage    events.elements
 */
$events = $this->requestAction(array('controller' => 'events', 'action' => 'upcomingEvents'));
?>
<h2>Upcoming Events</h2>
<?php foreach ($events as $event): ?>
<article class="contents" id="event-contents">
	<figure class="image-right"><?php echo $this->FormatImage->idImage('events', $event['Event']['id']); ?></figure>
	<h3><?php echo $event['Event']['name']; ?></h3>
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
