<?php
/**
 * Posts view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Events.View
 */
$this->extend('/Common/view');

$this->assign('title', $event['Event']['name']);
$this->assign('contentStartDate', $event['Event']['date_start']);
$this->assign('contentEndDate', $event['Event']['date_end']);
$this->assign('sectionModified', $event['Event']['modified']);
$this->assign('contentThumbnail', $this->FormatImage->idImage('events/'.$event['Event']['year'], $event['Event']['id'], array('class' => 'img-thumbnail pull-right'), 'events'));
?>
		<p>@ <span class="event-location"><?php echo $event['Event']['location']; ?></span></p>
		<p><?php echo $event['Event']['description']; ?></p>
		<?php if ($event['Event']['webpage']): ?>
			<p>Web: <?php echo $this->Html->link($event['Event']['webpage'], $event['Event']['webpage'], array('target' => '_blank')); ?></p>
		<?php endif; ?>
