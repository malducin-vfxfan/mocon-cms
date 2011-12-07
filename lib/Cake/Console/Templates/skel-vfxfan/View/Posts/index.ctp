<?php
/**
 * Short description.
 *
 * Long description.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009, 2011, ILMfan (http://ilmfan.com)
 * @link          http://ilmfan.com ILMfan
 * @package       $packagename$
 * @subpackage    posts
 */
?>
<div class="row">
	<section class="page-content" id="posts">
		<h1>Posts</h1>

		<?php foreach ($posts as $post): ?>
		<article class="contents" id="post-contents">
			<figure class="image-right"><?php echo $this->FormatImage->idImage('posts', $post['Post']['id']); ?></figure>
			<h2><?php echo $post['Post']['title']; ?></h2>
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
				echo $this->Paginator->first('first');
				echo $this->Paginator->prev('« previous', array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => ''));
				echo $this->Paginator->next('next »', array(), null, array('class' => 'next disabled'));
				echo $this->Paginator->last('last');
			?>
			</div>
		</nav>
	</section>
</div>
