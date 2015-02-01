<?php
/**
 * Posts view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Events
 */
$preview_image = $this->FormatImage->getPreviewImage($event['Event']['preview_images']);
?>
<?php if (!empty($preview_image)): ?>
<article>
	<div class="row">
		<div class="content-preview-image">
			<?php echo $this->Html->image('events/'.$event['Event']['year'].'/'.sprintf("%010d", $event['Event']['id']).'/'.$preview_image, array('class' => 'img-responsive center-block', 'alt' => $event['Event']['name'], 'title' => $event['Event']['name'])); ?>
		</div>
		<div class="content-preview">
			<header>
				<h1>Event: <?php echo $event['Event']['name']; ?></h1>
				<p>
					<time class="date-start" datetime="<?php echo $event['Event']['date_start']; ?>">
						<?php echo strftime("%B %d, %Y", strtotime($event['Event']['date_start'])); ?>
					</time>
					-
					<time class="date-end" datetime="<?php echo $event['Event']['date_end']; ?>">
						<?php echo strftime("%B %d, %Y", strtotime($event['Event']['date_end'])); ?>
					</time>
					@ <span class="event-location"><?php echo $event['Event']['location']; ?></span></p>
			</header>
		</div>
	</div>
	<p><?php echo $event['Event']['description']; ?></p>
	<?php if ($event['Event']['webpage']): ?>
		<p>Web: <?php echo $this->Html->link($event['Event']['webpage'], $event['Event']['webpage'], array('target' => '_blank')); ?></p>
	<?php endif; ?>
</article>
<?php else: ?>
<article>
	<header>
		<h1>Event: <?php echo $event['Event']['name']; ?></h1>
		<p>
			<time class="date-start" datetime="<?php echo $event['Event']['date_start']; ?>">
				<?php echo strftime("%B %d, %Y", strtotime($event['Event']['date_start'])); ?>
			</time>
			-
			<time class="date-end" datetime="<?php echo $event['Event']['date_end']; ?>">
				<?php echo strftime("%B %d, %Y", strtotime($event['Event']['date_end'])); ?>
			</time>
			@ <span class="event-location"><?php echo $event['Event']['location']; ?></span>
		</p>
	</header>
	<p><?php echo $event['Event']['description']; ?></p>
	<?php if ($event['Event']['webpage']): ?>
		<p>Web: <?php echo $this->Html->link($event['Event']['webpage'], $event['Event']['webpage'], array('target' => '_blank')); ?></p>
	<?php endif; ?>
</article>
<?php endif; ?>
<aside>
	<p id="event-modified">
		<small>Event last modified:
			<time class="date-modified" datetime="<?php echo date(DATE_ATOM, strtotime($event['Event']['modified'])); ?>">
				<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($event['Event']['modified'])); ?>
			</time>
		</small>
	</p>
</aside>
