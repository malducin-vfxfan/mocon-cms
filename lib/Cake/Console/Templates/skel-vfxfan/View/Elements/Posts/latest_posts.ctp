<?php
/**
 * Latest Posts element.
 *
 * Latest Posts element.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       $packagename$
 * @subpackage    posts
 */
$posts = $this->requestAction(array('controller' => 'posts', 'action' => 'latest_posts'));
?>
<h2>Latest News</h2>
<?php foreach ($posts as $post): ?>
		<article class="contents" id="post-contents">
			<figure class="image-right"><?php echo $this->FormatImage->idImage('posts', $post['Post']['id']); ?></figure>
			<h3><?php echo $post['Post']['title']; ?></h3>
			<div class="content-info">
				<time class="date-created" datetime="<?php echo date(DATE_ATOM, strtotime($post['Post']['created'])); ?>">
					<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($post['Post']['created'])); ?>
				</time>
				<div class="author">by <?php echo $post['User']['username']; ?></div>
			</div>
			<p class="contents-summary"><?php echo $post['Post']['summary']; ?></p>
		    <p><?php echo $this->Html->link('Read more »', array('controller' => 'posts', 'action' => 'view', $post['Post']['slug'])); ?></p>
		</article>
		<hr />
<?php endforeach; ?>