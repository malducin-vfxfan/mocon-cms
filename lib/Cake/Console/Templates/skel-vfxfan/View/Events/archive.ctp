<?php
/**
 * Events admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Events.View
 */
$this->extend('/Common/index');

$this->assign('title', 'Past Events');
$this->assign('contentId', 'events');
?>
		<?php foreach ($events as $event): ?>
		<article class="event-contents">
			<?php echo $this->FormatImage->idImage('events/'.$event['Event']['year'], $event['Event']['id'], array('class' => 'img-thumbnail pull-right'), 'events'); ?>
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
