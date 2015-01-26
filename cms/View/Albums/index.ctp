<?php
/**
 * Albums admin index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Albums
 */
$this->extend('/Common/index');

$this->assign('title', 'Albums');
$this->assign('contentId', 'albums');
?>
		<?php
		foreach ($albums as $album):
			$preview_image = $this->FormatImage->getPreviewImage($album['Album']['preview_images']);
		?>
			<?php if (!empty($preview_image)): ?>
				<article class="row">
					<div class="content-preview-image">
						<?php echo $this->Html->image('albums/'.$album['Album']['year'].'/'.sprintf("%010d", $album['Album']['id']).'/preview/'.$preview_image, array('class' => 'img-responsive center-block', 'alt' => $album['Album']['name'], 'title' => $album['Album']['name'])); ?>
					</div>
					<div class="content-preview">
						<header>
							<h2><?php echo $album['Album']['name']; ?></h2>
							<div class="content-detail text-muted">
								<p><time class="date-created" datetime="<?php echo date(DATE_ATOM, strtotime($album['Album']['created'])); ?>">
									<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($album['Album']['created'])); ?>
								</time></p>
							</div>
						</header>
						<p><?php echo $album['Album']['description']; ?></p>
						<p><?php echo $this->Html->link('View album', array('controller' => 'albums', 'action' => 'view', $album['Album']['slug']), array('class' => 'btn btn-primary')); ?></p>
					</div>
				</article>
			<?php else: ?>
				<article class="album-contents">
					<header>
						<h2><?php echo $album['Album']['name']; ?></h2>
						<div class="content-detail text-muted">
							<p><time class="date-created" datetime="<?php echo date(DATE_ATOM, strtotime($album['Album']['created'])); ?>">
								<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($album['Album']['created'])); ?>
							</time></p>
						</div>
					</header>
					<p><?php echo $album['Album']['description']; ?></p>
					<p><?php echo $this->Html->link('View album', array('controller' => 'albums', 'action' => 'view', $album['Album']['slug']), array('class' => 'btn btn-primary')); ?></p>
				</article>
			<?php endif; ?>

			<hr />
		<?php endforeach; ?>
