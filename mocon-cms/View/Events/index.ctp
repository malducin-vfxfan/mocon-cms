<?php
/**
 * Events admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.Events
 */
$this->extend('/Common/index');

$this->assign('title', 'Upcoming Events');
$this->assign('contentId', 'events');
?>
<?php
		foreach ($events as $event):
			$preview_image = $this->FormatImage->getPreviewImage($event['Event']['preview_images']);
		?>
			<?php if (!empty($preview_image)): ?>
				<article class="row">
					<div class="content-preview-image">
						<?php echo $this->Html->image('events/'.$event['Event']['year'].'/'.sprintf("%010d", $event['Event']['id']).'/'.$preview_image, array('class' => 'img-responsive center-block', 'alt' => $event['Event']['name'], 'title' => $event['Event']['name'])); ?>
					</div>
					<div class="content-preview">
						<header>
							<h2><?php echo $event['Event']['name']; ?></h2>
							<p><time class="date-start" datetime="<?php echo $event['Event']['date_start']; ?>">
							<?php echo strftime("%B %d, %Y", strtotime($event['Event']['date_start'])); ?>
							</time>
							-
							<time class="date-end" datetime="<?php echo $event['Event']['date_end']; ?>">
								<?php echo strftime("%B %d, %Y", strtotime($event['Event']['date_end'])); ?>
							</time>
							@ <span class="event-location"><?php echo $event['Event']['location']; ?></span></p>
						</header>
						<p><?php echo $event['Event']['description']; ?></p>
						<?php if ($event['Event']['webpage']): ?>
						<p>Web: <?php echo $this->Html->link($event['Event']['webpage'], $event['Event']['webpage'], array('target' => '_blank')); ?></p>
						<?php endif; ?>
					</div>
				</article>
			<?php else: ?>
				<article>
					<header>
						<h2><?php echo $event['Event']['name']; ?></h2>
						<p><time class="date-start" datetime="<?php echo $event['Event']['date_start']; ?>">
						<?php echo strftime("%B %d, %Y", strtotime($event['Event']['date_start'])); ?>
						</time>
						-
						<time class="date-end" datetime="<?php echo $event['Event']['date_end']; ?>">
							<?php echo strftime("%B %d, %Y", strtotime($event['Event']['date_end'])); ?>
						</time>
						@ <span class="event-location"><?php echo $event['Event']['location']; ?></span></p>
					</header>
					<p><?php echo $event['Event']['description']; ?></p>
					<?php if ($event['Event']['webpage']): ?>
					<p>Web: <?php echo $this->Html->link($event['Event']['webpage'], $event['Event']['webpage'], array('target' => '_blank')); ?></p>
					<?php endif; ?>
				</article>
			<?php endif; ?>

				<hr />
		<?php endforeach; ?>
