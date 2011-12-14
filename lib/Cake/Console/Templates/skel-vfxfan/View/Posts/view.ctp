<?php
/**
 * Posts view view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       posts
 * @subpackage    posts.views
 */
?>
<div class="row">
	<article class="page-content" id="post-contents">
		<figure class="image-right"><?php echo $this->FormatImage->idImage('posts', $post['Post']['id']); ?></figure>
		<header>
			<h1><?php echo $post['Post']['title']; ?></h1>
		</header>
		<div class="content-info">
			<time class="date-created" datetime="<?php echo date(DATE_ATOM, strtotime($post['Post']['created'])); ?>">
				<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($post['Post']['created'])); ?>
			</time>
			<p>by <span class="author"><?php echo $post['User']['username']; ?></span></p>
			<?php
				if (Configure::read('AddThis.posts')) {
					echo $this->element('AddThis/post', array('slug' => $post['Post']['slug'], 'post_title' => $post['Post']['title']));
				}
			?>
		</div>
		<p class="contents-summary">
			<?php echo $post['Post']['summary']; ?>
		</p>
		<div class="contents">
			<?php echo $post['Post']['content']; ?>
		</div>
		<footer id="post-modified">
			<p><small>Post last modified:
				<time class="date-modified" datetime="<?php echo date(DATE_ATOM, strtotime($post['Post']['modified'])); ?>">
					<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($post['Post']['modified'])); ?>
				</time>
			</small></p>
		</footer>
	</article>
</div>
