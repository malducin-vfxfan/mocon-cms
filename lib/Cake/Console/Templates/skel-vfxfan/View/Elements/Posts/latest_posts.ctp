<?php
/**
 * Latest Posts element.
 *
 * Calls the latest_posts method of the posts system to get a short
 * list of posts to display (mainly in the main page).
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       posts
 * @subpackage    posts.views.elements
 */
$posts = $this->requestAction(array('controller' => 'posts', 'action' => 'latestPosts'));
?>
<h2>Latest News</h2>
<?php foreach ($posts as $post): ?>
		<article class="post-contents">
			<?php echo $this->FormatImage->idImage('posts/'.$post['Post']['year'], $post['Post']['id'], array('class' => 'framed image-right'), 'posts'); ?>
			<header>
				<h3><?php echo $post['Post']['title']; ?></h3>
				<time class="date-created" datetime="<?php echo date(DATE_ATOM, strtotime($post['Post']['created'])); ?>">
					<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($post['Post']['created'])); ?>
				</time>
				<p class="author">by <?php echo $post['User']['username']; ?></p>
			</header>
			<div>
				<?php
					if (Configure::read('AddThis.posts')) {
						echo $this->element('AddThis/post', array('slug' => $post['Post']['slug'], 'post_title' => $post['Post']['title']));
					}
				?>
			</div>
			<p class="contents-summary"><?php echo $post['Post']['summary']; ?></p>
			<p><?php echo $this->Html->link('Read more »', array('controller' => 'posts', 'action' => 'view', $post['Post']['slug'])); ?></p>
		</article>
		<hr />
<?php endforeach; ?>