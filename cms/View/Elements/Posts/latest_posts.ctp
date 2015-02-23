<?php
/**
 * Latest Posts element.
 *
 * Calls the latest_posts method of the posts system to get a short
 * list of posts to display (mainly in the main page).
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.Elements.Posts
 */
?>
<h2>Latest News</h2>
<?php
foreach ($posts as $post):
	$preview_image = $this->FormatImage->getPreviewImage($post['Post']['preview_images']);
?>
	<?php if (!empty($preview_image)): ?>
		<article class="row">
			<div class="content-preview-image">
				<?php echo $this->Html->image('posts/'.$post['Post']['year'].'/'.sprintf("%010d", $post['Post']['id']).'/'.$preview_image, array('class' => 'img-responsive center-block', 'alt' => $post['Post']['title'], 'title' => $post['Post']['title'])); ?>
			</div>
			<div class="content-preview">
				<header>
					<h3><?php echo $post['Post']['title']; ?></h3>
					<div class="content-detail text-muted">
						<p><time class="date-created" datetime="<?php echo date(DATE_ATOM, strtotime($post['Post']['created'])); ?>">
						<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($post['Post']['created'])); ?>,
						</time>
						by <span class="author"><?php echo $post['User']['username']; ?></span></p>
					</div>
				</header>
				<div>
					<?php
						if (Configure::read('AddThis.posts')) {
							echo $this->element('AddThis/post', array('slug' => $post['Post']['slug'], 'post_title' => $post['Post']['title']));
						}
					?>
				</div>
				<p><?php echo $post['Post']['summary']; ?></p>
				<p><?php echo $this->Html->link('Read More', array('controller' => 'posts', 'action' => 'view', $post['Post']['slug']), array('class' => 'btn btn-primary')); ?></p>
			</div>
		</article>
	<?php else: ?>
		<article>
			<header>
				<h3><?php echo $post['Post']['title']; ?></h3>
				<div class="content-detail text-muted">
					<p><time class="date-created" datetime="<?php echo date(DATE_ATOM, strtotime($post['Post']['created'])); ?>">
					<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($post['Post']['created'])); ?>,
					</time>
					by <span class="author"><?php echo $post['User']['username']; ?></span></p>
				</div>
			</header>
			<div>
				<?php
					if (Configure::read('AddThis.posts')) {
						echo $this->element('AddThis/post', array('slug' => $post['Post']['slug'], 'post_title' => $post['Post']['title']));
					}
				?>
			</div>
			<p><?php echo $post['Post']['summary']; ?><p>
			<p><?php echo $this->Html->link('Read More', array('controller' => 'posts', 'action' => 'view', $post['Post']['slug']), array('class' => 'btn btn-primary')); ?></p>
		</article>
	<?php endif; ?>

		<hr />
<?php endforeach; ?>
