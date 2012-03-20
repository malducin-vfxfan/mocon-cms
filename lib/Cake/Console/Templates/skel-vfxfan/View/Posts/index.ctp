<?php
/**
 * Posts index view.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, ILMfan (http://ilmfan.com)
 * @link          http://ilmfan.com ILMfan
 * @package       posts
 * @subpackage    posts.views
 */
?>
<div class="row">
	<section class="page-content" id="posts">
		<h1>Posts</h1>

		<?php foreach ($posts as $post): ?>
		<article class="post-contents">
			<?php echo $this->FormatImage->idImage('posts/'.$post['Post']['year'], $post['Post']['id'], array('class' => 'thumbnail image-right'), 'posts'); ?>
			<header>
				<h2><?php echo $post['Post']['title']; ?></h2>
				<time class="date-created" datetime="<?php echo date(DATE_ATOM, strtotime($post['Post']['created'])); ?>">
					<?php echo strftime("%B %d, %Y %H:%M:%S", strtotime($post['Post']['created'])); ?>
				</time>
				<p>by <span class="author"><?php echo $post['User']['username']; ?></span></p>
			</header>
			<div>
				<?php
					if (Configure::read('AddThis.posts')) {
						echo $this->element('AddThis/post', array('slug' => $post['Post']['slug'], 'post_title' => $post['Post']['title']));
					}
				?>
			</div>
			<p><?php echo $post['Post']['summary']; ?></p>
			<p><?php echo $this->Html->link('Read more »', array('controller' => 'posts', 'action' => 'view', $post['Post']['slug'])); ?></p>
		</article>
		<hr />
		<?php endforeach; ?>
		<nav class="paginator">
			<p>
			<?php
				echo $this->Paginator->counter(array(
					'format' => 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'
				));
			?>
			</p>

			<div class="paging">
			<?php
				echo $this->Paginator->prev('« previous', array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => '', 'first' => 'first', 'last' => 'last'));
				echo $this->Paginator->next('next »', array(), null, array('class' => 'next disabled'));
			?>
			</div>
		</nav>
	</section>
</div>
